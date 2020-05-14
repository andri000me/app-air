<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_Controller{
    //fungsi untuk pembuatan laporan dan penagihan
    public function laporan_darat() {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"darat_keuangan");

        if($result != NULL){
            $total = 0;
            $ton = 0;
            $no = 1;

            $tabel = '<center><h4>Laporan Pendapatan Air Darat Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                    <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">No Kwitansi</th>
                            <th align="center">Nama Pengguna Jasa</th>
                            <th align="center">Alamat</th>
                            <th align="center">No Telepon</th>
                            <th align="center">Tanggal Transaksi</th>
                            <th align="center">Status Pembayaran</th>
                            <th align="center">Tarif</th>
                            <th align="center">Total Permintaan (Ton)</th>
                            <th align="center">Total Pembayaran (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach($result as $row){
                if($row->diskon != NULL || $row->diskon != 0){
                    $row->tarif -= $row->tarif * $row->diskon/100;
                    $total_pembayaran = $row->tarif * $row->total_permintaan ;
                }
                else{
                    $total_pembayaran = $row->tarif * $row->total_permintaan;
                }

                if($row->status_invoice == '1')
                    $status_pembayaran = "Piutang";
                else
                    $status_pembayaran = "Cash";

                if($this->session->userdata('role_name') == 'keuangan'){
                    if($row->status_pembayaran == 1 && $row->status_invoice == 0) {
                        $total += $total_pembayaran;
                        $ton += $row->total_permintaan;
                        $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi));

                        $tabel .= '<tr>
                        <td align="center">' . $no . '</td>
                        <td align="center">' . $row->no_kwitansi . '</td>
                        <td align="center">' . $row->nama_pengguna_jasa . '</td>
                        <td align="center">' . $row->alamat . '</td>
                        <td align="center">' . $row->no_telp . '</td>
                        <td align="center">' . $format_tgl . '</td>
                        <td align="center">' . $status_pembayaran . '</td>
                        <td align="center">' . $this->Ribuan($row->tarif) . '</td>
                        <td align="center">' . $row->total_permintaan . '</td>
                        <td align="center">' . $this->Ribuan($total_pembayaran) . '</td>
                    </tr>
                    ';
                        $no++;
                    }
                } else {
                    $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi));

                    if($row->batal_kwitansi == 0){
                        $ton += $row->total_permintaan;
                        $total += $total_pembayaran;

                        $tabel .= '<tr>
                        <td align="center">' . $no . '</td>
                        <td align="center">' . $row->no_kwitansi . '</td>
                        <td align="center">' . $row->nama_pengguna_jasa . '</td>
                        <td align="center">' . $row->alamat . '</td>
                        <td align="center">' . $row->no_telp . '</td>
                        <td align="center">' . $format_tgl . '</td>
                        <td align="center">' . $status_pembayaran . '</td>
                        <td align="center">' . $this->Ribuan($row->tarif) . '</td>
                        <td align="center">' . $row->total_permintaan . '</td>
                        <td align="center">' . $this->Ribuan($total_pembayaran) . '</td>
                    </tr>';
                        $no++;
                    } else{
                        $total_pembayaran = 'Kwitansi Batal';

                        $tabel .= '<tr style="background-color: #990000">
                        <td align="center">' . $no . '</td>
                        <td align="center">' . $row->no_kwitansi . '</td>
                        <td align="center">' . $row->nama_pengguna_jasa . '</td>
                        <td align="center">' . $row->alamat . '</td>
                        <td align="center">' . $row->no_telp . '</td>
                        <td align="center">' . $format_tgl . '</td>
                        <td align="center">' . $status_pembayaran . '</td>
                        <td align="center">' . $this->Ribuan($row->tarif) . '</td>
                        <td align="center">' . $row->total_permintaan . '</td>
                        <td align="center">' . $total_pembayaran . '</td>
                    </tr>';
                        $no++;
                    }
                }
            }

            $tabel .= '<tr>
                        <td align="center" colspan="8"><b>Total</b></td>
                        <td align="center"><b>'.$ton.'</b></td>
                        <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                    </tr>
                </tbody>
                </table>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/darat").'>Cetak PDF</a>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/excelDarat/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';

            $data = array(
                'status' => 'success',
                'tabel' => $tabel
            );
        }
        else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function laporanDarat(){
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"darat");

        if($this->session->userdata('role_name') == 'loket'){
            if($result != NULL){
                $total = 0;
                $ton = 0;
                $no = 1;

                $tabel = '<center><h4>Laporan Pendapatan Air Darat Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                    <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">Nama Pengguna Jasa</th>
                            <th align="center">Alamat</th>
                            <th align="center">Tanggal Transaksi</th>
                            <th align="center">Waktu Permintaan Pengantaran</th>
                            <th align="center">Waktu Mulai Pengantaran</th>
                            <th align="center">Waktu Selesai Pengantaran</th>
                            <th align="center">Lama Pengantaran</th>
                            <th align="center">Status Pembayaran</th>
                            <th align="center">Tarif (Rp.)</th>
                            <th align="center">Total Permintaan (Ton)</th>
                            <th align="center">Total Pembayaran (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>';

                foreach($result as $row){
                    $lama_pengantaran = 0;
                    $format_jam_awal = "";
                    $format_jam_akhir = "";

                    if($row->batal_kwitansi == 1){
                        $total_pembayaran = 0;
                    } else if($row->diskon != NULL || $row->diskon != 0){
                        $row->tarif -= $row->tarif * $row->diskon/100;
                        $total_pembayaran = $row->tarif * $row->total_permintaan ;
                    } else{
                        $total_pembayaran = $row->tarif * $row->total_permintaan;
                    }

                    if($row->waktu_mulai_pengantaran == NULL){
                        $format_jam_awal = "";
                    } else if($row->waktu_selesai_pengantaran == NULL){
                        $format_jam_akhir = "";
                    } else {
                        $format_jam_awal = date("d-m-y H:i:s",strtotime($row->waktu_mulai_pengantaran));
                        $format_jam_akhir = date("d-m-y H:i:s",strtotime($row->waktu_selesai_pengantaran));

                        $waktu_awal = mktime(date("H",strtotime($row->waktu_mulai_pengantaran)),date("i",strtotime($row->waktu_mulai_pengantaran)),date("s",strtotime($row->waktu_mulai_pengantaran)),date("m",strtotime($row->waktu_mulai_pengantaran)),date("d",strtotime($row->waktu_mulai_pengantaran)),date("y",strtotime($row->waktu_mulai_pengantaran)));
                        $waktu_akhir = mktime(date("H",strtotime($row->waktu_selesai_pengantaran)),date("i",strtotime($row->waktu_selesai_pengantaran)),date("s",strtotime($row->waktu_selesai_pengantaran)),date("m",strtotime($row->waktu_selesai_pengantaran)),date("d",strtotime($row->waktu_selesai_pengantaran)),date("y",strtotime($row->waktu_selesai_pengantaran)) );
                        $lama_pengantaran = round((($waktu_akhir - $waktu_awal) % 86400)/3600,2);
                    }

                    if($lama_pengantaran > 1){
                        $lama_pengantaran .= " Jam";
                    }else {
                        $lama_pengantaran = $lama_pengantaran * 60;
                        if ($lama_pengantaran > 1){
                            $lama_pengantaran .= " Menit";
                        }else {
                            $lama_pengantaran = $lama_pengantaran * 60;
                            $lama_pengantaran .= " Detik";
                        }
                    }
                    $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));
                    $format_tgl_pengantaran = date('d-m-Y H:i:s', strtotime($row->tgl_perm_pengantaran ));

                    $total += $total_pembayaran;

                    if($row->status_invoice == '1')
                        $status_pembayaran = "Piutang";
                    else
                        $status_pembayaran = "Cash";

                    if($row->batal_kwitansi == 0){
                        $ton += $row->total_permintaan;

                        $tabel .='<tr>
                        <td align="center">'.$no.'</td>
                        <td align="center">'.$row->nama_pengguna_jasa.'</td>
                        <td align="center">'.$row->alamat.'</td>
                        <td align="center">'.$format_tgl.'</td>
                        <td align="center">'.$format_tgl_pengantaran.'</td>
                        <td align="center">'.$format_jam_awal.'</td>
                        <td align="center">'.$format_jam_akhir.'</td>
                        <td align="center">'.$lama_pengantaran.'</td>
                        <td align="center">'.$status_pembayaran.'</td>
                        <td align="center">'.$this->Ribuan($row->tarif).'</td>
                        <td align="center">'.$row->total_permintaan.'</td>
                        <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                    </tr>';
                        $no++;
                    } else {
                        $total_pembayaran = "Kwitansi Di Batalkan";
                        $tabel .='<tr style="background-color: #990000">
                        <td align="center">'.$no.'</td>
                        <td align="center">'.$row->nama_pengguna_jasa.'</td>
                        <td align="center">'.$row->alamat.'</td>
                        <td align="center">'.$format_tgl.'</td>
                        <td align="center">'.$format_tgl_pengantaran.'</td>
                        <td align="center">'.$format_jam_awal.'</td>
                        <td align="center">'.$format_jam_akhir.'</td>
                        <td align="center">'.$lama_pengantaran.'</td>
                        <td align="center">'.$status_pembayaran.'</td>
                        <td align="center">'.$this->Ribuan($row->tarif).'</td>
                        <td align="center">'.$row->total_permintaan.'</td>
                        <td align="center">'.$total_pembayaran.'</td>
                    </tr>';
                        $no++;
                    }
                }

                $tabel .= '<tr>
                        <td align="center" colspan="10"><b>Total</b></td>
                        <td align="center"><b>'.$ton.'</b></td>
                        <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                    </tr>
                </tbody>
                </table>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/darat").'>Cetak PDF</a>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/excelDarat/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';

                $data = array(
                    'status' => 'success',
                    'tabel' => $tabel
                );
            }
            else{
                $data = array(
                    'status' => 'failed'
                );
            }
        }
        else{
            if($result != NULL){
                $total = 0;
                $ton = 0;
                $no = 1;

                $tabel = '<center><h4>Laporan Pendapatan Air Darat Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                    <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">Nama Pengguna Jasa</th>
                            <th align="center">Alamat</th>
                            <th align="center">Tanggal Transaksi</th>
                            <th align="center">Waktu Permintaan Pengantaran</th>
                            <th align="center">Waktu Mulai Pengantaran</th>
                            <th align="center">Waktu Selesai Pengantaran</th>
                            <th align="center">Lama Pengantaran</th>
                            <th align="center">Status Pembayaran</th>
                            <th align="center">Total Permintaan (Ton)</th>
                            <th align="center">Total Pembayaran (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>';

                foreach($result as $row){
                    $lama_pengantaran = 0;
                    $format_jam_awal = "";
                    $format_jam_akhir = "";

                    if($row->batal_kwitansi == 1){
                        $total_pembayaran = 0;
                    } else if($row->diskon != NULL || $row->diskon != 0){
                        $row->tarif -= $row->tarif * $row->diskon/100;
                        $total_pembayaran = $row->tarif * $row->total_permintaan ;
                    } else{
                        $total_pembayaran = $row->tarif * $row->total_permintaan;
                    }

                    if($row->waktu_mulai_pengantaran == NULL){
                        $format_jam_awal = "";
                    } else if($row->waktu_selesai_pengantaran == NULL){
                        $format_jam_akhir = "";
                    } else {
                        $format_jam_awal = date("d-m-y H:i:s",strtotime($row->waktu_mulai_pengantaran));
                        $format_jam_akhir = date("d-m-y H:i:s",strtotime($row->waktu_selesai_pengantaran));

                        $waktu_awal = mktime(date("H",strtotime($row->waktu_mulai_pengantaran)),date("i",strtotime($row->waktu_mulai_pengantaran)),date("s",strtotime($row->waktu_mulai_pengantaran)),date("m",strtotime($row->waktu_mulai_pengantaran)),date("d",strtotime($row->waktu_mulai_pengantaran)),date("y",strtotime($row->waktu_mulai_pengantaran)));
                        $waktu_akhir = mktime(date("H",strtotime($row->waktu_selesai_pengantaran)),date("i",strtotime($row->waktu_selesai_pengantaran)),date("s",strtotime($row->waktu_selesai_pengantaran)),date("m",strtotime($row->waktu_selesai_pengantaran)),date("d",strtotime($row->waktu_selesai_pengantaran)),date("y",strtotime($row->waktu_selesai_pengantaran)) );
                        $lama_pengantaran = round((($waktu_akhir - $waktu_awal) % 86400)/3600,2);
                    }

                    if($lama_pengantaran > 1){
                        $lama_pengantaran .= " Jam";
                    }else {
                        $lama_pengantaran = $lama_pengantaran * 60;
                        if ($lama_pengantaran > 1){
                            $lama_pengantaran .= " Menit";
                        }else {
                            $lama_pengantaran = $lama_pengantaran * 60;
                            $lama_pengantaran .= " Detik";
                        }
                    }

                    $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));
                    $format_tgl_pengantaran = date('d-m-Y H:i:s', strtotime($row->tgl_perm_pengantaran ));

                    $total += $total_pembayaran;

                    if($row->status_invoice == '1')
                        $status_pembayaran = "Piutang";
                    else
                        $status_pembayaran = "Cash";

                    if($row->batal_kwitansi == 0){
                        $ton += $row->total_permintaan;

                        $tabel .='<tr>
                        <td align="center">'.$no.'</td>
                        <td align="center">'.$row->nama_pengguna_jasa.'</td>
                        <td align="center">'.$row->alamat.'</td>
                        <td align="center">'.$format_tgl.'</td>
                        <td align="center">'.$format_tgl_pengantaran.'</td>
                        <td align="center">'.$format_jam_awal.'</td>
                        <td align="center">'.$format_jam_akhir.'</td>
                        <td align="center">'.$lama_pengantaran.'</td>
                        <td align="center">'.$status_pembayaran.'</td>
                        <td align="center">'.$row->total_permintaan.'</td>
                        <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                    </tr>';
                        $no++;
                    } else {
                        $total_pembayaran = "Kwitansi Di Batalkan";
                        $tabel .='<tr style="background-color: #990000">
                        <td align="center">'.$no.'</td>
                        <td align="center">'.$row->nama_pengguna_jasa.'</td>
                        <td align="center">'.$row->alamat.'</td>
                        <td align="center">'.$format_tgl.'</td>
                        <td align="center">'.$format_tgl_pengantaran.'</td>
                        <td align="center">'.$format_jam_awal.'</td>
                        <td align="center">'.$format_jam_akhir.'</td>
                        <td align="center">'.$lama_pengantaran.'</td>
                        <td align="center">'.$status_pembayaran.'</td>
                        <td align="center">'.$row->total_permintaan.'</td>
                        <td align="center">'.$total_pembayaran.'</td>
                    </tr>';
                        $no++;
                    }
                }

                $tabel .= '<tr>
                        <td align="center" colspan="9"><b>Total</b></td>
                        <td align="center"><b>'.$ton.'</b></td>
                        <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                    </tr>
                </tbody>
                </table>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/darat").'>Cetak PDF</a>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/excelDarat/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';

                $data = array(
                    'status' => 'success',
                    'tabel' => $tabel
                );
            }
            else{
                $data = array(
                    'status' => 'failed'
                );
            }
        }

        echo json_encode($data);
    }

    public function laporan_laut(){
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"laut");
       

        if($result != NULL){
            $total = 0;
            $ton = 0;
            $no = 1;
            $ton_realiasi = 0;

            if($this->session->userdata('role_name') == 'keuangan'){
                $tabel = '<center><h4>Laporan Pendapatan Air Kapal Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                    <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">No Nota</th>
                            <th align="center">No Faktur</th>
                            <th align="center">ID VESSEL</th>
                            <th align="center">Nama VESSEL</th>
                            <th align="center">Voy No</th>
                            <th align="center">Tipe Kapal</th>
                            <th align="center">Nama Perusahaan</th>
                            <th align="center">Tanggal Transaksi</th>
                            <th align="center">Tarif (Rp.)</th>
                            <th align="center">Total Permintaan (Ton)</th>
                            <th align="center">Realisasi Pengisian (Ton)</th>
                            <th align="center">Total Pembayaran (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>';
            }
            else {
                $tabel = '<center><h4>Laporan Pendapatan Air Kapal Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                    <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">ID VESSEL</th>
                            <th align="center">Nama VESSEL</th>
                            <th align="center">Voy No</th>
                            <th align="center">Tipe Kapal</th>
                            <th align="center">Nama Perusahaan</th>
                            <th align="center">Tanggal Transaksi</th>
                            <th align="center">Tarif (Rp.)</th>
                            <th align="center">Total Permintaan (Ton)</th>
                            <th align="center">Realisasi Pengisian (Ton)</th>
                            <th align="center">Total Pembayaran (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>';
            }

            foreach($result as $row){
                if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL){
                    if($this->session->userdata('role_name') == 'keuangan'){
                        if($row->id_ref_transaksi != NULL){
                            if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                                $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;

                                if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                    $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                                    if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                        $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    } else{
                                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    }
                                }
                                else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                    $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                }
                                else {
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                }
                            }
                            else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                                if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                    $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                } else {
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                }
                            }
                            else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                            }
                            else{
                                $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                            }

                            if($row->diskon != NULL || $row->diskon != 0){
                                $row->tarif -= $row->tarif * $row->diskon/100;
                                $total_pembayaran = $row->tarif  * $realisasi;
                            }
                            else{
                                $total_pembayaran = $row->tarif * $realisasi;
                            }

                            if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                                $total_pembayaran += 3000;
                            } else if($total_pembayaran > 1000000){
                                $total_pembayaran += 6000;
                            } else{
                                $total_pembayaran += 0;
                            }

                            $total += $total_pembayaran;
                            $ton += $row->total_permintaan;
                            $ton_realiasi += $realisasi;
                            $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                            if($row->pengguna_jasa_id_tarif == 8){
                                $row->pengguna_jasa_id_tarif = "Peti Kemas";
                            }else{
                                $row->pengguna_jasa_id_tarif = "Tongkang";
                            }

                            $tabel .='<tr>
                        <td align="center">'.$no.'</td>
                        <td align="center">'.$row->no_nota.'</td>
                        <td align="center">'.$row->no_faktur.'</td>
                        <td align="center">'.$row->id_vessel.'</td>
                        <td align="center">'.$row->nama_vessel.'</td>
                        <td align="center">'.$row->voy_no.'</td>
                        <td align="center">'.$row->pengguna_jasa_id_tarif.'</td>
                        <td align="center">'.$row->nama_agent.'</td>
                        <td align="center">'.$format_tgl.'</td>
                        <td align="center">'.$this->Ribuan($row->tarif).'</td>
                        <td align="center">'.$row->total_permintaan.'</td>
                        <td align="center">'.$realisasi.'</td>
                        <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                      </tr>
                      ';
                            $no++;
                        }
                    }
                    else if($this->session->userdata('role_name') == 'wtp' || $this->session->userdata('role_name') == 'perencanaan'){
                        if($row->flowmeter_awal == NULL || $row->flowmeter_awal == '0'){
                            $flowmeter_awal = "0";
                        }
                        else{
                            $flowmeter_awal = $row->flowmeter_awal;
                        }

                        if($row->flowmeter_akhir == NULL || $row->flowmeter_akhir == '0'){
                            $flowmeter_akhir = "0";
                        }
                        else{
                            $flowmeter_akhir = $row->flowmeter_akhir;
                        }

                        if($row->flowmeter_awal_2 == NULL || $row->flowmeter_awal_2 == '0'){
                            $flowmeter_awal_2 = "0";
                        }
                        else{
                            $flowmeter_awal_2 = $row->flowmeter_awal_2;
                        }

                        if($row->flowmeter_akhir_2 == NULL || $row->flowmeter_akhir_2 == '0'){
                            $flowmeter_akhir_2 = "0";
                        }
                        else{
                            $flowmeter_akhir_2 = $row->flowmeter_akhir_2;
                        }

                        if($row->flowmeter_awal_3 == NULL || $row->flowmeter_awal_3 == '0'){
                            $flowmeter_awal_3 = "0";
                        }
                        else{
                            $flowmeter_awal_3 = $row->flowmeter_awal_3;
                        }

                        if($row->flowmeter_akhir_3 == NULL || $row->flowmeter_akhir_3 == '0'){
                            $flowmeter_akhir_3 = "0";
                        }
                        else{
                            $flowmeter_akhir_3 = $row->flowmeter_akhir_3;
                        }

                        if($row->flowmeter_awal_4 == NULL || $row->flowmeter_awal_4 == '0'){
                            $flowmeter_awal_4 = "0";
                        }
                        else{
                            $flowmeter_awal_4 = $row->flowmeter_awal_4;
                        }

                        if($row->flowmeter_akhir_4 == NULL || $row->flowmeter_akhir_4 == '0'){
                            $flowmeter_akhir_4 = "0";
                        }
                        else{
                            $flowmeter_akhir_4 = $row->flowmeter_akhir_4;
                        }

                        if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                            $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;
                            $flow_sebelum = $flowmeter_awal_4;
                            $flow_sesudah = $flowmeter_akhir_4;

                            if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                                $flow_sebelum .= " , ".$flowmeter_awal_3;
                                $flow_sesudah .= " , ".$flowmeter_akhir_3;

                                if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                    $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                    $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                                } else{
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    $flow_sebelum .= " , ".$flowmeter_awal;
                                    $flow_sesudah .= " , ".$flowmeter_akhir;
                                }
                            }
                            else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                            }
                            else {
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                $flow_sebelum .= " , ".$flowmeter_awal;
                                $flow_sesudah .= " , ".$flowmeter_akhir;
                            }
                        }
                        else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                            $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                            $flow_sebelum = $flowmeter_awal_3;
                            $flow_sesudah = $flowmeter_akhir_3;

                            if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                            } else {
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                $flow_sebelum .= " , ".$flowmeter_awal;
                                $flow_sesudah .= " , ".$flowmeter_akhir;
                            }
                        }
                        else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                            $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                            $flow_sebelum = $flowmeter_awal_2." , ".$flowmeter_awal;
                            $flow_sesudah = $flowmeter_akhir_2." , ".$flowmeter_akhir;
                        }
                        else{
                            $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                            $flow_sebelum = $flowmeter_awal;
                            $flow_sesudah = $flowmeter_akhir;
                        }

                        if($row->diskon != NULL || $row->diskon != 0){
                            $row->tarif -= $row->tarif * $row->diskon/100;
                            $total_pembayaran = $row->tarif  * $realisasi;
                        }
                        else{
                            $total_pembayaran = $row->tarif * $realisasi;
                        }

                        if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                            $total_pembayaran += 3000;
                        } else if($total_pembayaran > 1000000){
                            $total_pembayaran += 6000;
                        } else{
                            $total_pembayaran += 0;
                        }

                        $total += $total_pembayaran;
                        $ton += $row->total_permintaan;
                        $ton_realiasi += $realisasi;
                        $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                        if($row->tipe_kapal == 8){
                            $row->tipe_kapal = "Peti Kemas";
                        }else{
                            $row->tipe_kapal = "Tongkang";
                        }

                        $tabel .='<tr>
                        <td align="center">'.$no.'</td>
                        <td align="center">'.$row->id_vessel.'</td>
                        <td align="center">'.$row->nama_vessel.'</td>
                        <td align="center">'.$row->voy_no.'</td>
                        <td align="center">'.$row->tipe_kapal.'</td>
                        <td align="center">'.$row->nama_agent.'</td>
                        <td align="center">'.$format_tgl.'</td>
                        <td align="center">'.$flow_sebelum.'</td>
                        <td align="center">'.$flow_sesudah.'</td>
                        <td align="center">'.$row->total_permintaan.'</td>
                        <td align="center">'.$realisasi.'</td>
                        <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                      </tr>
                      ';
                        $no++;
                    }
                    else {
                        if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                            $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;

                            if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                                if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                    $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                } else{
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                }
                            }
                            else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                            }
                            else {
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                            }
                        }
                        else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                            $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                            if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                            } else {
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                            }
                        }
                        else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                            $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        }
                        else{
                            $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                        }

                        if($row->diskon != NULL || $row->diskon != 0){
                            $row->tarif -= $row->tarif * $row->diskon/100;
                            $total_pembayaran = $row->tarif * $realisasi;
                        }
                        else{
                            $total_pembayaran = $row->tarif * $realisasi;
                        }

                        if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                            $total_pembayaran += 3000;
                        } else if($total_pembayaran > 1000000){
                            $total_pembayaran += 6000;
                        } else{
                            $total_pembayaran += 0;
                        }

                        $total += $total_pembayaran;
                        $ton += $row->total_permintaan;
                        $ton_realiasi += $realisasi;
                        $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                        if($row->pengguna_jasa_id_tarif == 8){
                            $row->pengguna_jasa_id_tarif = "Peti Kemas";
                        }else{
                            $row->pengguna_jasa_id_tarif = "Tongkang";
                        }

                        $tabel .='<tr>
                          <td align="center">'.$no.'</td>
                          <td align="center">'.$row->id_vessel.'</td>
                          <td align="center">'.$row->nama_vessel.'</td>
                          <td align="center">'.$row->voy_no.'</td>
                          <td align="center">'.$row->pengguna_jasa_id_tarif.'</td>
                          <td align="center">'.$row->nama_agent.'</td>
                          <td align="center">'.$format_tgl.'</td>
                          <td align="center">'.$this->Ribuan($row->tarif).'</td>
                          <td align="center">'.$row->total_permintaan.'</td>
                          <td align="center">'.$realisasi.'</td>
                          <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                      </tr>
                      ';
                        $no++;
                    }
                }
            }

            if($this->session->userdata('role_name') == 'keuangan' ){
                $tabel .= '<tr>
                          <td align="center" colspan="10"><b>Total</b></td>
                          <td align="center"><b>'.$ton.'</b></td>
                          <td align="center"><b>'.$ton_realiasi.'</b></td>
                          <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                      </tr>
                  </tbody>
                  </table>
                  <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/laut").'>Cetak PDF</a>
                  <a class="btn btn-primary" target="_blank" href='.base_url("report/excelLaut/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';
            }
            else if($this->session->userdata('role_name') == 'operasi'){
                $tabel .= '<tr>
                          <td align="center" colspan="8"><b>Total</b></td>
                          <td align="center"><b>'.$ton.'</b></td>
                          <td align="center"><b>'.$ton_realiasi.'</b></td>
                          <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                      </tr>
                  </tbody>
                  </table>
                  <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/laut").'>Cetak PDF</a>
                  <a class="btn btn-primary" target="_blank" href='.base_url("report/excelLaut/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';
            }
            else {
                $tabel .= '<tr>
                          <td align="center" colspan="8"><b>Total</b></td>
                          <td align="center"><b>'.$ton.'</b></td>
                          <td align="center"><b>'.$ton_realiasi.'</b></td>
                          <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                      </tr>
                  </tbody>
                  </table>
                  <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/laut").'>Cetak PDF</a>
                  <a class="btn btn-primary" target="_blank" href='.base_url("report/excelLaut/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';
            }

            $data = array(
                'status' => 'success',
                'tabel' => $tabel
            );
        }
        else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function laporanLaut(){
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"laut_operasi");

        if($result != NULL){
            $total = 0;
            $ton = 0;
            $no = 1;
            $ton_realiasi = 0;

            if($this->session->userdata('role_name') == 'keuangan'){
                $tabel = '<center><h4>Laporan Pendapatan Air Kapal Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                    <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">No Nota</th>
                            <th align="center">No Faktur</th>
                            <th align="center">ID VESSEL</th>
                            <th align="center">Nama VESSEL</th>
                            <th align="center">Voy No</th>
                            <th align="center">Tipe Kapal</th>
                            <th align="center">Nama Perusahaan</th>
                            <th align="center">Tanggal Transaksi</th>
                            <th align="center">Tarif (Rp.)</th>
                            <th align="center">Total Permintaan (Ton)</th>
                            <th align="center">Realisasi Pengisian (Ton)</th>
                            <th align="center">Total Pembayaran (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>';
            }
            else if($this->session->userdata('role_name') == 'operasi') {
                $tabel = '<center><h4>Laporan Pendapatan Air Kapal Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                    <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">ID VESSEL</th>
                            <th align="center">Nama VESSEL</th>
                            <th align="center">Voy No</th>
                            <th align="center">Tipe Kapal</th>
                            <th align="center">Nama Perusahaan</th>
                            <th align="center">Tanggal Transaksi</th>
                            <th align="center">Tarif (Rp.)</th>
                            <th align="center">Total Permintaan (Ton)</th>
                            <th align="center">Realisasi Pengisian (Ton)</th>
                            <th align="center">Total Pembayaran (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>';
            }
            else {
                $tabel = '<center><h4>Laporan Pendapatan Air Kapal Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                    <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">ID VESSEL</th>
                            <th align="center">Nama VESSEL</th>
                            <th align="center">Voy No</th>
                            <th align="center">Tipe Kapal</th>
                            <th align="center">Nama Perusahaan</th>
                            <th align="center">Tanggal Transaksi</th>
                            <th align="center">Flow Meter Awal</th>
                            <th align="center">Flow Meter Akhir</th>
                            <th align="center">Total Permintaan (Ton)</th>
                            <th align="center">Realisasi Pengisian (Ton)</th>
                            <th align="center">Total Pembayaran (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>';
            }

            if($result != NULL ){
                foreach($result as $row){
                    if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL){
                        if($this->session->userdata('role_name') == 'keuangan'){
                            if($row->realisasi_transaksi_laut_id_realisasi != NULL){
                                if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                                    $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;
    
                                    if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                        $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
    
                                        if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                            $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                        } else{
                                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                        }
                                    }
                                    else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                        $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    }
                                    else {
                                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    }
                                }
                                else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                    $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
    
                                    if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                        $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    } else {
                                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    }
                                }
                                else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                    $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                }
                                else{
                                    $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                                }
    
                                if($row->diskon != NULL || $row->diskon != 0){
                                    $row->tarif -= $row->tarif * $row->diskon/100;
                                    $total_pembayaran = $row->tarif  * $realisasi;
                                }
                                else{
                                    $total_pembayaran = $row->tarif * $realisasi;
                                }
    
                                if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                                    $total_pembayaran += 3000;
                                } else if($total_pembayaran > 1000000){
                                    $total_pembayaran += 6000;
                                } else{
                                    $total_pembayaran += 0;
                                }
    
                                $total += $total_pembayaran;
                                $ton += $row->total_permintaan;
                                $ton_realiasi += $realisasi;
                                $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));
    
                                if($row->pengguna_jasa_id_tarif == 6){
                                    $row->pengguna_jasa_id_tarif = "Peti Kemas";
                                }else{
                                    $row->pengguna_jasa_id_tarif = "Tongkang";
                                }
    
                                $tabel .='<tr>
                              <td align="center">'.$no.'</td>
                              <td align="center">'.$row->no_nota.'</td>
                              <td align="center">'.$row->no_faktur.'</td>
                              <td align="center">'.$row->id_vessel.'</td>
                              <td align="center">'.$row->nama_vessel.'</td>
                              <td align="center">'.$row->voy_no.'</td>
                              <td align="center">'.$row->pengguna_jasa_id_tarif.'</td>
                              <td align="center">'.$row->nama_agent.'</td>
                              <td align="center">'.$format_tgl.'</td>
                              <td align="center">'.$this->Ribuan($row->tarif).'</td>
                              <td align="center">'.$row->total_permintaan.'</td>
                              <td align="center">'.$realisasi.'</td>
                              <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                          </tr>
                          ';
                                $no++;
                            }
                        }
                        else if($this->session->userdata('role_name') == 'wtp' || $this->session->userdata('role_name') == 'perencanaan' || $this->session->userdata('role_name') == 'admin'){
                            if($row->flowmeter_awal == NULL || $row->flowmeter_awal == '0'){
                                $flowmeter_awal = "0";
                            }
                            else{
                                $flowmeter_awal = $row->flowmeter_awal;
                            }
    
                            if($row->flowmeter_akhir == NULL || $row->flowmeter_akhir == '0'){
                                $flowmeter_akhir = "0";
                            }
                            else{
                                $flowmeter_akhir = $row->flowmeter_akhir;
                            }
    
                            if($row->flowmeter_awal_2 == NULL || $row->flowmeter_awal_2 == '0'){
                                $flowmeter_awal_2 = "0";
                            }
                            else{
                                $flowmeter_awal_2 = $row->flowmeter_awal_2;
                            }
    
                            if($row->flowmeter_akhir_2 == NULL || $row->flowmeter_akhir_2 == '0'){
                                $flowmeter_akhir_2 = "0";
                            }
                            else{
                                $flowmeter_akhir_2 = $row->flowmeter_akhir_2;
                            }
    
                            if($row->flowmeter_awal_3 == NULL || $row->flowmeter_awal_3 == '0'){
                                $flowmeter_awal_3 = "0";
                            }
                            else{
                                $flowmeter_awal_3 = $row->flowmeter_awal_3;
                            }
    
                            if($row->flowmeter_akhir_3 == NULL || $row->flowmeter_akhir_3 == '0'){
                                $flowmeter_akhir_3 = "0";
                            }
                            else{
                                $flowmeter_akhir_3 = $row->flowmeter_akhir_3;
                            }
    
                            if($row->flowmeter_awal_4 == NULL || $row->flowmeter_awal_4 == '0'){
                                $flowmeter_awal_4 = "0";
                            }
                            else{
                                $flowmeter_awal_4 = $row->flowmeter_awal_4;
                            }
    
                            if($row->flowmeter_akhir_4 == NULL || $row->flowmeter_akhir_4 == '0'){
                                $flowmeter_akhir_4 = "0";
                            }
                            else{
                                $flowmeter_akhir_4 = $row->flowmeter_akhir_4;
                            }
    
                            if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                                $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;
                                $flow_sebelum = $flowmeter_awal_4;
                                $flow_sesudah = $flowmeter_akhir_4;
    
                                if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                    $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                                    $flow_sebelum .= " , ".$flowmeter_awal_3;
                                    $flow_sesudah .= " , ".$flowmeter_akhir_3;
    
                                    if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                        $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                        $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                        $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                                    } else{
                                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                        $flow_sebelum .= " , ".$flowmeter_awal;
                                        $flow_sesudah .= " , ".$flowmeter_akhir;
                                    }
                                }
                                else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                    $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                    $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                                }
                                else {
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    $flow_sebelum .= " , ".$flowmeter_awal;
                                    $flow_sesudah .= " , ".$flowmeter_akhir;
                                }
                            }
                            else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                                $flow_sebelum = $flowmeter_awal_3;
                                $flow_sesudah = $flowmeter_akhir_3;
    
                                if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                    $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                    $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                                } else {
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    $flow_sebelum .= " , ".$flowmeter_awal;
                                    $flow_sesudah .= " , ".$flowmeter_akhir;
                                }
                            }
                            else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                $flow_sebelum = $flowmeter_awal_2." , ".$flowmeter_awal;
                                $flow_sesudah = $flowmeter_akhir_2." , ".$flowmeter_akhir;
                            }
                            else{
                                $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                                $flow_sebelum = $flowmeter_awal;
                                $flow_sesudah = $flowmeter_akhir;
                            }
    
                            if($row->diskon != NULL || $row->diskon != 0){
                                $row->tarif -= $row->tarif * $row->diskon/100;
                                $total_pembayaran = $row->tarif  * $realisasi;
                            }
                            else{
                                $total_pembayaran = $row->tarif * $realisasi;
                            }
    
                            if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                                $total_pembayaran += 3000;
                            } else if($total_pembayaran > 1000000){
                                $total_pembayaran += 6000;
                            } else{
                                $total_pembayaran += 0;
                            }
    
                            $total += $total_pembayaran;
                            $ton += $row->total_permintaan;
                            $ton_realiasi += $realisasi;
                            $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));
    
                            if($row->tipe_kapal == 8){
                                $row->tipe_kapal = "Peti Kemas";
                            }else{
                                $row->tipe_kapal = "Tongkang";
                            }
    
                            $tabel .='<tr>
                              <td align="center">'.$no.'</td>
                              <td align="center">'.$row->id_vessel.'</td>
                              <td align="center">'.$row->nama_vessel.'</td>
                              <td align="center">'.$row->voy_no.'</td>
                              <td align="center">'.$row->tipe_kapal.'</td>
                              <td align="center">'.$row->nama_agent.'</td>
                              <td align="center">'.$format_tgl.'</td>
                              <td align="center">'.$flow_sebelum.'</td>
                              <td align="center">'.$flow_sesudah.'</td>
                              <td align="center">'.$row->total_permintaan.'</td>
                              <td align="center">'.$realisasi.'</td>
                              <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                          </tr>
                          ';
                            $no++;
                        }
                        else {
                            if($row->flowmeter_awal == NULL || $row->flowmeter_awal == '0'){
                                $flowmeter_awal = "0";
                            }
                            else{
                                $flowmeter_awal = $row->flowmeter_awal;
                            }
    
                            if($row->flowmeter_akhir == NULL || $row->flowmeter_akhir == '0'){
                                $flowmeter_akhir = "0";
                            }
                            else{
                                $flowmeter_akhir = $row->flowmeter_akhir;
                            }
    
                            if($row->flowmeter_awal_2 == NULL || $row->flowmeter_awal_2 == '0'){
                                $flowmeter_awal_2 = "0";
                            }
                            else{
                                $flowmeter_awal_2 = $row->flowmeter_awal_2;
                            }
    
                            if($row->flowmeter_akhir_2 == NULL || $row->flowmeter_akhir_2 == '0'){
                                $flowmeter_akhir_2 = "0";
                            }
                            else{
                                $flowmeter_akhir_2 = $row->flowmeter_akhir_2;
                            }
    
                            if($row->flowmeter_awal_3 == NULL || $row->flowmeter_awal_3 == '0'){
                                $flowmeter_awal_3 = "0";
                            }
                            else{
                                $flowmeter_awal_3 = $row->flowmeter_awal_3;
                            }
    
                            if($row->flowmeter_akhir_3 == NULL || $row->flowmeter_akhir_3 == '0'){
                                $flowmeter_akhir_3 = "0";
                            }
                            else{
                                $flowmeter_akhir_3 = $row->flowmeter_akhir_3;
                            }
    
                            if($row->flowmeter_awal_4 == NULL || $row->flowmeter_awal_4 == '0'){
                                $flowmeter_awal_4 = "0";
                            }
                            else{
                                $flowmeter_awal_4 = $row->flowmeter_awal_4;
                            }
    
                            if($row->flowmeter_akhir_4 == NULL || $row->flowmeter_akhir_4 == '0'){
                                $flowmeter_akhir_4 = "0";
                            }
                            else{
                                $flowmeter_akhir_4 = $row->flowmeter_akhir_4;
                            }
    
                            if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                                $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;
                                $flow_sebelum = $flowmeter_awal_4;
                                $flow_sesudah = $flowmeter_akhir_4;
    
                                if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                    $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                                    $flow_sebelum .= " , ".$flowmeter_awal_3;
                                    $flow_sesudah .= " , ".$flowmeter_akhir_3;
    
                                    if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                        $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                        $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                        $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                                    } else{
                                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                        $flow_sebelum .= " , ".$flowmeter_awal;
                                        $flow_sesudah .= " , ".$flowmeter_akhir;
                                    }
                                }
                                else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                    $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                    $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                                }
                                else {
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    $flow_sebelum .= " , ".$flowmeter_awal;
                                    $flow_sesudah .= " , ".$flowmeter_akhir;
                                }
                            }
                            else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                                $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                                $flow_sebelum = $flowmeter_awal_3;
                                $flow_sesudah = $flowmeter_akhir_3;
    
                                if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                    $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                                    $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                                } else {
                                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                    $flow_sebelum .= " , ".$flowmeter_awal;
                                    $flow_sesudah .= " , ".$flowmeter_akhir;
                                }
                            }
                            else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                                $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                                $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                                $flow_sebelum = $flowmeter_awal_2." , ".$flowmeter_awal;
                                $flow_sesudah = $flowmeter_akhir_2." , ".$flowmeter_akhir;
                            }
                            else{
                                $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                                $flow_sebelum = $flowmeter_awal;
                                $flow_sesudah = $flowmeter_akhir;
                            }
    
                            if($row->diskon != NULL || $row->diskon != 0){
                                $row->tarif -= $row->tarif * $row->diskon/100;
                                $total_pembayaran = $row->tarif * $realisasi;
                            }
                            else{
                                $total_pembayaran = $row->tarif * $realisasi;
                            }
    
                            if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                                $total_pembayaran += 3000;
                            } else if($total_pembayaran > 1000000){
                                $total_pembayaran += 6000;
                            } else{
                                $total_pembayaran += 0;
                            }

                            if($row->status_print == '1'){
                                $total += $total_pembayaran;
                                $ton += $row->total_permintaan;
                                $ton_realiasi += $realisasi;
                                $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));
        
                                if($row->pengguna_jasa_id_tarif == 8){
                                    $row->pengguna_jasa_id_tarif = "Peti Kemas";
                                }else{
                                    $row->pengguna_jasa_id_tarif = "Tongkang";
                                }
                                
                                $tabel .='<tr>
                                <td align="center">'.$no.'</td>
                                <td align="center">'.$row->id_vessel.'</td>
                                <td align="center">'.$row->nama_vessel.'</td>
                                <td align="center">'.$row->voy_no.'</td>
                                <td align="center">'.$row->pengguna_jasa_id_tarif.'</td>
                                <td align="center">'.$row->nama_agent.'</td>
                                <td align="center">'.$format_tgl.'</td>
                                <td align="center">'.$this->Ribuan($row->tarif).'</td>
                                <td align="center">'.$row->total_permintaan.'</td>
                                <td align="center">'.$realisasi.'</td>
                                <td align="center">'.$this->Ribuan($total_pembayaran).'</td>
                                </tr>
                                ';
                            }
    
                            
                            $no++;
                        }
                    }
                }
            }
            
            if($this->session->userdata('role_name') == 'keuangan' ){
                $tabel .= '<tr>
                        <td align="center" colspan="10"><b>Total</b></td>
                        <td align="center"><b>'.$ton.'</b></td>
                        <td align="center"><b>'.$ton_realiasi.'</b></td>
                        <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                    </tr>
                </tbody>
                </table>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/laut").'>Cetak PDF</a>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/excelLaut/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';
            }
            else if($this->session->userdata('role_name') == 'operasi'){
                $tabel .= '<tr>
                        <td align="center" colspan="8"><b>Total</b></td>
                        <td align="center"><b>'.$ton.'</b></td>
                        <td align="center"><b>'.$ton_realiasi.'</b></td>
                        <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                    </tr>
                </tbody>
                </table>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/laut_operasi").'>Cetak PDF</a>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/excelLaut/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';
            }
            else {
                $tabel .= '<tr>
                        <td align="center" colspan="9"><b>Total</b></td>
                        <td align="center"><b>'.$ton.'</b></td>
                        <td align="center"><b>'.$ton_realiasi.'</b></td>
                        <td align="center"><b>'.$this->Ribuan($total).'</b></td>
                    </tr>
                </tbody>
                </table>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/laut_operasi").'>Cetak PDF</a>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/excelLaut/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';
            }

            $data = array(
                'status' => 'success',
                'tabel' => $tabel
            );
        }
        else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function laporan_ruko() {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"ruko");

        if($result != NULL){
            $total_pembayaran =0;
            $ton_total = 0;
            $ton = 0;
            $no = 1;
            $no_perjanjian='';

            $tabel = '<center><h4>Laporan Pendapatan Air Ruko Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                    <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <tr>
                            <th align="center">No</th>
                            <th align="center">ID Flow Meter</th>
                            <th align="center">Nama Tenant</th>
                            <th align="center">No Perjanjian</th>
                            <th align="center">Tarif</th>
                            <th align="center">Diskon</th>
                            <th align="center">Pemakaian Awal</th>
                            <th align="center">Pemakaian Akhir</th>
                            <th align="center">Total Penggunaan</th>
                            <th align="center">Total Pembayaran (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach($result as $row){
                $data_tagihan = $this->tenant->getTagihan($tgl_awal,$tgl_akhir,$row->id_flow);

                $ttl_akhir = 0;
                $ttl_awal = 0;
                $i = 1;
                $diskon = '';

                if($data_tagihan != NULL) {
                    foreach ($data_tagihan as $data) {
                        if ($data->id_ref_flowmeter == $row->id_flow) {
                            if ($i == 1 && $data->flow_hari_ini != NULL) {
                                $ttl_awal = $data->flow_hari_ini;
                            } else {
                                if ($ttl_awal == 0) {
                                    $ttl_awal = $data->flow_hari_ini;
                                }
                            }
                            if ($i == count($data_tagihan) && $data->flow_hari_ini != NULL) {
                                $ttl_akhir = $data->flow_hari_ini;
                            }
                            $i++;
                        } else {
                            $i = 1;
                        }
                    }

                    $ton_koma = $ttl_akhir - $ttl_awal;
                    $ton_total += $ton_koma;
                    $ton = $this->Koma($ton_koma);
                    $diskon = $row->diskon;
                    $tarif = $row->tarif;
                } else{
                    $ton = 0;
                    $no_perjanjian = $row->no_perjanjian;
                    $diskon = '';
                    $tarif = $row->nominal;
                }
                    if($row->id_ref_tenant == NULL){
                        if($row->diskon != NULL){
                            $pembayaran = ($row->tarif - ($row->tarif * $row->diskon/100)) * $ton;
                        }
                        else{
                            $pembayaran = $row->tarif * $ton;
                        }
                    } else {
                        $date_now = strtotime(date('Y-m-d',time() ));
                        $date_kadaluarsa = strtotime($row->waktu_kadaluarsa);
                        if($date_now < $date_kadaluarsa || $date_now == $date_kadaluarsa)
                            $pembayaran = $row->nominal;
                        else
                            $pembayaran = 0;
                    }

                    $total_pembayaran += $pembayaran;

                    $tabel .='<tr>
                          <td align="center">'.$no.'</td>
                          <td align="center">'.$row->id_flowmeter.'</td>
                          <td align="center">'.$row->nama_tenant.'</td>
                          <td align="center">'.$no_perjanjian.'</td>
                          <td align="center">'.$this->Ribuan($tarif).'</td>
                          <td align="center">'.$diskon.'</td>
                          <td align="center">'.$ttl_awal.'</td>
                          <td align="center">'.$ttl_akhir.'</td>
                          <td align="center">'.$ton.'</td>
                          <td align="center">'.$this->Ribuan($pembayaran).'</td>
                      </tr>
                      ';
                    $no++;

            }

            $tabel .= '<tr>
                          <td align="center" colspan="8"><b>Total</b></td>
                          <td align="center"><b>'.$this->Koma($ton_total).'</b></td>
                          <td align="center"><b>'.$this->Ribuan($total_pembayaran).'</b></td>
                      </tr>
                  </tbody>
                  </table>
                  <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/ruko").'>Cetak PDF</a>
                  <a class="btn btn-primary" target="_blank" href='.base_url("report/excelRuko/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';

            $data = array(
                'status' => 'success',
                'tabel' => $tabel
            );
        }
        else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function laporan_ruko_keuangan() {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');

        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"ruko_keuangan");

        if($result != NULL){
            $total_pembayaran =0;
            $ton_total = 0;
            $no = 1;

            $tabel = '<center><h4>Laporan Pendapatan Air Ruko Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                      <table class="table table-responsive table-condensed table-striped">
                      <thead>
                          <tr>
                              <th align="center">No</th>
                              <th align="center">No Invoice</th>
                              <th align="center">No Nota</th>
                              <th align="center">No Faktur</th>
                              <th align="center">Nama Tenant</th>
                              <th align="center">No Perjanjian</th>
                              <th align="center">Alamat</th>
                              <th align="center">No. Telepon</th>
                              <th align="center">Total Penggunaan</th>
                              <th align="center">Total Pembayaran (Rp.)</th>
                          </tr>
                      </thead>
                      <tbody>';

            foreach($result as $row){
                $data_tagihan = $this->tenant->getTagihan($tgl_awal,$tgl_akhir,$row->id_flow);

                $ttl_akhir = 0;
                $ttl_awal = 0;
                $no_perjanjian = '';
                $i = 1;

                if($data_tagihan != NULL) {
                    foreach ($data_tagihan as $data) {
                        if ($data->id_ref_flowmeter == $row->id_flow) {
                            if ($i == 1 && $data->flow_hari_ini != NULL) {
                                $ttl_awal = $data->flow_hari_ini;
                            } else {
                                if ($ttl_awal == 0) {
                                    $ttl_awal = $data->flow_hari_ini;
                                }
                            }
                            if ($i == count($data_tagihan) && $data->flow_hari_ini != NULL) {
                                $ttl_akhir = $data->flow_hari_ini;
                            }
                            $i++;
                        } else {
                            $i = 1;
                        }
                    }

                    $ton_koma = $ttl_akhir - $ttl_awal;
                    $ton_total += $ton_koma;
                    $ton = $this->Koma($ton_koma);
                } else{
                    $ton = 0;
                    $no_perjanjian = $row->no_perjanjian;
                }

                    if($row->id_ref_tenant == NULL){
                        if($row->diskon != NULL){
                            $pembayaran = ($row->tarif - ($row->tarif * $row->diskon/100)) * $ton;
                        }
                        else{
                            $pembayaran = $row->tarif * $ton;
                        }
                    } else {
                        $date_now = strtotime(date('Y-m-d',time() ));
                        $date_kadaluarsa = strtotime($row->waktu_kadaluarsa);
                        if($date_now < $date_kadaluarsa || $date_now == $date_kadaluarsa)
                            $pembayaran = $row->nominal;
                        else
                            $pembayaran = 0;
                    }

                    $total_pembayaran += $pembayaran;

                    $tabel .='<tr>
                          <td align="center">'.$no.'</td>
                          <td align="center">'.$row->no_invoice.'</td>
                          <td align="center">'.$row->no_nota.'</td>
                          <td align="center">'.$row->no_faktur.'</td>
                          <td align="center">'.$row->nama_tenant.'</td>
                          <td align="center">'.$no_perjanjian.'</td>
                          <td align="center">'.$row->lokasi.'</td>
                          <td align="center">'.$row->no_telp.'</td>
                          <td align="center">'.$ton.'</td>
                          <td align="center">'.$this->Ribuan($pembayaran).'</td>
                      </tr>
                      ';
                    $no++;

            }

            $tabel .= '<tr>
                          <td align="center" colspan="8"><b>Total</b></td>
                          <td align="center"><b>'.$this->Koma($ton_total).'</b></td>
                          <td align="center"><b>'.$this->Ribuan($total_pembayaran).'</b></td>
                      </tr>
                  </tbody>
                  </table>
                  <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/ruko_keuangan").'>Cetak PDF</a>
                  <a class="btn btn-primary" target="_blank" href='.base_url("report/excelRuko/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';

            $data = array(
                'status' => 'success',
                'tabel' => $tabel
            );
        }
        else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function laporan_flow() {
        $tgl_awal = $this->input->post('tgl_akhir');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"flow");

        if($result != NULL){
            $ton_total = 0;
            $no = 1;
            $tabel = '<center><h4>Laporan Pencatatan Flow Meter Per Tanggal '.date('d-m-Y', strtotime($tgl_akhir)).'</h4></center>
                      <table class="table table-responsive table-condensed table-striped">
                      <thead>
                          <tr>
                              <th align="center"><center>No</th>
                              <th align="center"><center>ID Flow Meter</th>
                              <th align="center"><center>Nama Flow Meter</th>
                              <th align="center"><center>Nilai Flow</th>
                              <th align="center"><center>Issued By</th>
                          </tr>
                      </thead>
                      <tbody>';

            foreach($result as $row){
                $data_tagihan = $this->tenant->getFlow($tgl_awal,$tgl_akhir,$row->id_flow);
                $ttl_akhir = 0;
                $ttl_awal = 0;
                $i = 1;
                $status_rekam = 0;
                if($data_tagihan != NULL){
                    foreach($data_tagihan as $data) {
                        if($data->id_ref_flowmeter == $row->id_flow){
                            if($i == 1 && $data->flow_hari_ini != NULL){
                                $ttl_awal = $data->flow_hari_ini;
                            }
                            else{
                                if($ttl_awal == 0){
                                    $ttl_awal = $data->flow_hari_ini;
                                }
                            }
                            if($i == count($data_tagihan) && $data->flow_hari_ini != NULL){
                                $ttl_akhir = $data->flow_hari_ini;
                            }
                            $i++;
                            $status_rekam = $data->status_perekaman;
                            $issuer = $data->issued_by;
                        }else{
                            $i=1;
                            $status_rekam = 0;
                        }
                    }

                    if($status_rekam == 1){
                        $tabel .='<tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->id_flowmeter.'</td>
                            <td align="center">'.$row->nama_flowmeter.'</td>
                            <td align="center">'.$ttl_akhir.'</td>
                            <td align="center">'.$issuer.'</td>
                        </tr>
                        ';
                        $no++;
                    }
                }
            }

            $tabel .= '
                </tbody>
                </table>
                
                <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/flow").'>Cetak PDF</a>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/excelFlow/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>
                
                ';

            $data = array(
                'status' => 'success',
                'tabel' => $tabel
            );
        }
        else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function laporan_per_flow() {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $id_flow = $this->input->post('id_flow');

        $no = 1;
        $data = $this->tenant->getFlow($tgl_awal,$tgl_akhir,$id_flow);
        $data_flow = $this->tenant->getDataFlowmeter($tgl_awal,$tgl_akhir,$id_flow);
        $tabel = '';

        if($data != NULL){
                $tabel = '
                <div class="col-sm-7">
                <table class="table table-responsive table-condensed table-striped">
                    <tr>
                        <td>ID Flow Meter</td>
                        <td>:</td>
                        <td>'.$data_flow->id_flowmeter.'</td>
                    </tr>
                    <tr>
                        <td>Nama Flow Meter</td>
                        <td>:</td>
                        <td>'.$data_flow->nama_flowmeter.'</td>
                    </tr>
                </table>
                </div>';
                $tabel .='
                <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <td>No</td>
                        <td>Tanggal Pencatatan</td>
                        <td>Nilai Flow</td>
                        <td>Issuer</td>
                    </thead>
            ';
                foreach ($data as $row){
                    $tabel .= '
                    <tr>
                        <td>'.$no.'</td>
                        <td>'.$row->waktu_perekaman.'</td>
                        <td>'.$row->flow_hari_ini.'</td>
                        <td>'.$row->issued_by.'</td>
                    </tr>';
                    $no++;
                }
                $tabel .= '</table>
                    <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/per_flow"."/".$id_flow).'>Cetak PDF</a>
                    <a class="btn btn-primary" target="_blank" href='.base_url("report/excelPerFlow/".$tgl_awal."/".$tgl_akhir."/".$id_flow).'>Cetak Excel</a>
                ';


            $data = array(
                'status' => 'success',
                'tabel' => $tabel,
                'url' => '<a class="btn btn-primary" target="_self" href='.base_url('tenant/buatTagihan/').$id_flow."/".$tgl_awal."/".$tgl_akhir.'>Buat Tagihan</a>'
            );
        }
        else{
            $data = array(
                'status' => 'fail',
                'message' => 'Data Tidak Ada'
            );
        }
        echo json_encode($data);
    }

    public function laporan_sumur() {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"sumur");

        if($result != NULL){
            $ton_total = 0;
            $no = 1;
            $tabel = '<center><h4>Laporan Pencatatan Sumur Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                      <table class="table table-responsive table-condensed table-striped">
                      <thead>
                          <tr>
                              <th align="center"><center>No</th>
                              <th align="center"><center>ID Sumur</th>
                              <th align="center"><center>Nama Sumur</th>
                              <th align="center"><center>Nama Pompa</th>
                              <th align="center"><center>Nama Flow Meter</th>
                              <th align="center"><center>Start Running</th>
                              <th align="center"><center>Cuaca</th>
                              <th align="center"><center>Debit Air (L/Detik)</th>
                              <th align="center"><center>Nilai Flow (m3)</th>
                              <th align="center"><center>Finish Running</th>
                              <th align="center"><center>Cuaca</th>
                              <th align="center"><center>Debit Air (L/Detik)</th>
                              <th align="center"><center>Nilai Flow Akhir (m3)</th>
                              <th align="center"><center>Pemakaian (m3)</th>
                              <th align="center"><center>Issued By</th>
                          </tr>
                      </thead>
                      <tbody>';

            foreach($result as $row){
                $ttl_akhir = 0;
                $ttl_awal = 0;

                $ttl_akhir = $row->flow_sumur_akhir;
                $ttl_awal = $row->flow_sumur_awal;

                $ton_koma = $ttl_akhir - $ttl_awal;
                $ton_total += $ton_koma;
                $ton = $this->Koma($ton_koma);

                $tabel .='<tr>
                          <td align="center">'.$no.'</td>
                          <td align="center">'.$row->id_sumur.'</td>
                          <td align="center">'.$row->nama_sumur.'</td>
                          <td align="center">'.$row->nama_pompa.'</td>
                          <td align="center">'.$row->nama_flowmeter.'</td>
                          <td align="center">'.$row->waktu_rekam_awal.'</td>
                          <td align="center">'.$row->cuaca_awal.'</td>
                          <td align="center">'.$row->debit_air_awal.'</td>
                          <td align="center">'.$row->flow_sumur_awal.'</td>
                          <td align="center">'.$row->waktu_rekam_akhir.'</td>
                          <td align="center">'.$row->cuaca_akhir.'</td>
                          <td align="center">'.$row->debit_air_akhir.'</td>
                          <td align="center">'.$row->flow_sumur_akhir.'</td>
                          <td align="center">'.$ton.'</td>
                          <td align="center">'.$row->issued_by.'</td>
                      </tr>
                      ';
                $no++;

            }

            $tabel .= '<tr>
                          <td align="center" colspan="13"><b>Total</b></td>
                          <td align="center"><b>'.$this->Koma($ton_total).'</b></td>
                          <td>&nbsp;</td>
                      </tr>
                  </tbody>
                  </table>
                  <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/sumur").'>Cetak PDF</a>
                  <a class="btn btn-primary" target="_blank" href='.base_url("report/excelSumur/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';

            $data = array(
                'status' => 'success',
                'tabel' => $tabel
            );
        }
        else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function laporan_tandon() {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"tandon");

        if($result != NULL){
            $ton_total = 0;
            $no = 1;
            $tabel = '<center><h4>Laporan Pencatatan Sumur Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                    <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <tr>
                            <th align="center"><center>No</th>
                            <th align="center"><center>Nama Tandon</th>
                            <th align="center"><center>Lokasi</th>
                            <th align="center"><center>Waktu Perekaman</th>
                            <th align="center"><center>Issued By</th>
                            <th align="center"><center>Total Pengisian (m3)</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach($result as $row){
                $ton_total += $row->total_pengisian;
                $ton = $this->Koma($row->total_pengisian);

                $tabel .='<tr>
                        <td align="center">'.$no.'</td>
                        <td align="center">'.$row->nama_tandon.'</td>
                        <td align="center">'.$row->lokasi.'</td>
                        <td align="center">'.$row->waktu_perekaman.'</td>
                        <td align="center">'.$row->issued_by.'</td>
                        <td align="center">'.$ton.'</td>
                    </tr>
                    ';
                $no++;

            }

            $tabel .= '<tr>
                        <td align="center" colspan="5"><b>Total</b></td>
                        <td align="center"><b>'.$this->Koma($ton_total).'</b></td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
                </table>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/tandon").'>Cetak PDF</a>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/excelTandon/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';

            $data = array(
                'status' => 'success',
                'tabel' => $tabel
            );
        }
        else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function laporanRealisasiAir() {
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"realisasiAir");

        if($result != NULL){
            $ton_total = 0;
            $no = 1;
            $tabel = '<center><h4>Laporan Realisasi Pemakaian Air Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>
                    <table class="table table-responsive table-condensed table-striped">
                    <thead>
                        <tr>
                            <th align="center"><center>No</th>
                            <th align="center"><center>Nama Tenant</th>
                            <th align="center"><center>Nama Flow Meter</th>
                            <th align="center"><center>Lokasi</th>
                            <th align="center"><center>Tanggal Awal Realisasi</th>
                            <th align="center"><center>Tanggal Akhir Realisasi</th>
                            <th align="center"><center>Flow Awal</th>
                            <th align="center"><center>Flow Akhir</th>
                            <th align="center"><center>Issued By</th>
                            <th align="center"><center>Total Pengisian (m3)</th>
                        </tr>
                    </thead>
                    <tbody>';

            foreach($result as $row){
                $ttl_awal = $row->flow_awal;
                $ttl_akhir = $row->flow_akhir;
                $ton = $ttl_akhir - $ttl_awal;
                $ton_total += $ton;

                $tabel .='<tr>
                        <td align="center">'.$no.'</td>
                        <td align="center">'.$row->nama_tenant.'</td>
                        <td align="center">'.$row->nama_flowmeter.'</td>
                        <td align="center">'.$row->lokasi.'</td>
                        <td align="center">'.$row->tgl_awal.'</td>
                        <td align="center">'.$row->tgl_akhir.'</td>
                        <td align="center">'.$ttl_awal.'</td>
                        <td align="center">'.$ttl_akhir.'</td>
                        <td align="center">'.$row->issued_by.'</td>
                        <td align="center">'.$this->koma($ton).'</td>
                    </tr>
                    ';
                $no++;

            }

            $tabel .= '<tr>
                        <td align="center" colspan="9"><b>Total</b></td>
                        <td align="center"><b>'.$this->Koma($ton_total).'</b></td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
                </table>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporan/".$tgl_awal."/".$tgl_akhir."/realisasiAir").'>Cetak PDF</a>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/excelRealisasiAir/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';

            $data = array(
                'status' => 'success',
                'tabel' => $tabel
            );
        }
        else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function excelDarat($tgl_awal,$tgl_akhir) {
        if($this->session->userdata('role_name') == 'keuangan'){
            $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"darat_keuangan");

            // Create new PHPExcel object
            $object = new PHPExcel();
            $style = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                )
            );
            $styleArray = array(
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $font = array(
                'font'  => array(
                    'bold'  => true,
                    'size'  => 12,
                    'name'  => 'Times New Roman'
                )
            );

            $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($styleArray);
            $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($font);
            $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
            $object->getActiveSheet()->getStyle('A7:J7')->getAlignment()->setWrapText(true);

            // Set properties
            $object->getProperties()->setCreator($this->session->userdata('first_name'))
                ->setLastModifiedBy($this->session->userdata('first_name'))
                ->setCategory("Approve by ");
            // Add some data
            $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);

            $object->getActiveSheet()->mergeCells('A1:J1');
            $object->getActiveSheet()->mergeCells('A2:J2');
            $object->getActiveSheet()->mergeCells('A3:J3');
            $object->getActiveSheet()->mergeCells('A4:J4');
            $object->getActiveSheet()->mergeCells('A5:J5');

            $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
            $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

            $object->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('first_name'))
                ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                ->setCellValue('A4', 'Terminal Peti Kemas')
                ->setCellValue('A5', 'Laporan Transaksi Air Darat Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'No Kwitansi')
                ->setCellValue('C7', 'Nama Pengguna Jasa')
                ->setCellValue('D7', 'Nama Pemohon')
                ->setCellValue('E7', 'Alamat')
                ->setCellValue('F7', 'No Telepon')
                ->setCellValue('G7', 'Tanggal Transaksi')
                ->setCellValue('H7', 'Tarif (Rp.)')
                ->setCellValue('I7', 'Total Permintaan (Ton)')
                ->setCellValue('J7', 'Total Pembayaran (Rp.)')
            ;
            $no=0;
            //add data
            $counter=8;
            $total = 0;
            $ton = 0;
            $ex = $object->setActiveSheetIndex(0);
            foreach($result as $row){
                if($row->status_pembayaran == 1 && $row->status_invoice == 0){
                    $no++;
                    $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);
                    $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($styleArray);

                    if($row->diskon != NULL || $row->diskon != 0){
                        $row->tarif -= $row->tarif * $row->diskon/100;
                        $total_pembayaran = $row->tarif * $row->total_permintaan ;
                    }
                    else{
                        $total_pembayaran = $row->tarif * $row->total_permintaan;
                    }

                    $waktu_awal = mktime(date("H",strtotime($row->waktu_mulai_pengantaran)),date("i",strtotime($row->waktu_mulai_pengantaran)),date("s",strtotime($row->waktu_mulai_pengantaran)),date("m",strtotime($row->waktu_mulai_pengantaran)),date("d",strtotime($row->waktu_mulai_pengantaran)),date("y",strtotime($row->waktu_mulai_pengantaran)));
                    $waktu_akhir = mktime(date("H",strtotime($row->waktu_selesai_pengantaran)),date("i",strtotime($row->waktu_selesai_pengantaran)),date("s",strtotime($row->waktu_selesai_pengantaran)),date("m",strtotime($row->waktu_selesai_pengantaran)),date("d",strtotime($row->waktu_selesai_pengantaran)),date("y",strtotime($row->waktu_selesai_pengantaran)) );

                    $total += $total_pembayaran;
                    $ton += $row->total_permintaan;
                    $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));

                    $ex->setCellValue("A".$counter,"$no");
                    $ex->setCellValue("B".$counter,"$row->no_kwitansi");
                    $ex->setCellValue("C".$counter,"$row->nama_pengguna_jasa");
                    $ex->setCellValue("D".$counter,"$row->nama_pemohon");
                    $ex->setCellValue("E".$counter,"$row->alamat");
                    $ex->setCellValue("F".$counter,"$row->no_telp");
                    $ex->setCellValue("G".$counter,"$format_tgl");
                    $ex->setCellValue("H".$counter,"$row->tarif");
                    $ex->setCellValue("I".$counter,"$row->total_permintaan");
                    $ex->setCellValue("J".$counter,"$total_pembayaran");
                    $counter=$counter+1;
                }
            }
            $object->getActiveSheet()->mergeCells('A'.$counter.':I'.$counter);
            $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($styleArray);
            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);

            $ex->setCellValue("A".$counter,"Total");
            $ex->setCellValue("I".$counter,"$ton");
            $ex->setCellValue("J".$counter,"$total");
            // Rename sheet
            $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Darat');

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $object->setActiveSheetIndex(0);

            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan_Transaksi_Darat_periode_'.$tgl_awal.'_'.$tgl_akhir.'.xlsx"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
            $objWriter->save('php://output');
        }
        else if($this->session->userdata('role_name') == 'operasi'){
            $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"darat");

            // Create new PHPExcel object
            $object = new PHPExcel();
            $style = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $font = array(
                'font'  => array(
                    'bold'  => true,
                    'size'  => 12,
                    'name'  => 'Times New Roman'
                )
            );
            $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($font);
            $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
            $object->getActiveSheet()->getStyle('A7:J7')->getAlignment()->setWrapText(true);

            // Set properties
            $object->getProperties()->setCreator($this->session->userdata('first_name'))
                ->setLastModifiedBy($this->session->userdata('first_name'))
                ->setCategory("Approve by ");
            // Add some data
            $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);

            $object->getActiveSheet()->mergeCells('A1:J1');
            $object->getActiveSheet()->mergeCells('A2:J2');
            $object->getActiveSheet()->mergeCells('A3:J3');
            $object->getActiveSheet()->mergeCells('A4:J4');
            $object->getActiveSheet()->mergeCells('A5:J5');

            $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
            $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

            $object->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('first_name'))
                ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                ->setCellValue('A4', 'Terminal Peti Kemas')
                ->setCellValue('A5', 'Laporan Transaksi Air Darat Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'No Kwitansi')
                ->setCellValue('C7', 'Nama Pengguna Jasa')
                ->setCellValue('D7', 'Nama Pemohon')
                ->setCellValue('E7', 'Alamat')
                ->setCellValue('F7', 'No Telepon')
                ->setCellValue('G7', 'Tanggal Transaksi')
                ->setCellValue('H7', 'Tarif (Rp.)')
                ->setCellValue('I7', 'Total Permintaan (Ton)')
                ->setCellValue('J7', 'Total Pembayaran (Rp.)')
            ;
            $no=0;
            //add data
            $counter=8;
            $total = 0;
            $ton = 0;
            $ex = $object->setActiveSheetIndex(0);
            foreach($result as $row){
                $no++;

                $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);

                if($row->batal_kwitansi == 1){
                    $total_pembayaran = '';
                }
                else if($row->diskon != NULL || $row->diskon != 0){
                    $row->tarif -= $row->tarif * $row->diskon/100;
                    $total_pembayaran = $row->tarif * $row->total_permintaan ;
                }
                else{
                    $total_pembayaran = $row->tarif * $row->total_permintaan;
                }

                if($row->batal_kwitansi == 0){
                    $total += $total_pembayaran;
                    $ton += $row->total_permintaan;
                }

                $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));

                $ex->setCellValue("A".$counter,"$no");
                $ex->setCellValue("B".$counter,"$row->no_kwitansi");
                $ex->setCellValue("C".$counter,"$row->nama_pengguna_jasa");
                $ex->setCellValue("D".$counter,"$row->nama_pemohon");
                $ex->setCellValue("E".$counter,"$row->alamat");
                $ex->setCellValue("F".$counter,"$row->no_telp");
                $ex->setCellValue("G".$counter,"$format_tgl");
                $ex->setCellValue("H".$counter,"$row->tarif");
                $ex->setCellValue("I".$counter,"$row->total_permintaan");
                $ex->setCellValue("J".$counter,"$total_pembayaran");
                $counter=$counter+1;

            }
            $object->getActiveSheet()->mergeCells('A'.$counter.':I'.$counter);
            $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);

            $ex->setCellValue("A".$counter,"Total");
            $ex->setCellValue("I".$counter,"$ton");
            $ex->setCellValue("J".$counter,"$total");
            // Rename sheet
            $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Darat');

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $object->setActiveSheetIndex(0);

            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan_Transaksi_Darat_periode_'.$_GET['id'].'_'.$_GET['id2'].'.xlsx"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
            $objWriter->save('php://output');
        }
        else if($this->session->userdata('role_name') == 'loket'){
            $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"darat");

            // Create new PHPExcel object
            $object = new PHPExcel();
            $style = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $font = array(
                'font'  => array(
                    'bold'  => true,
                    'size'  => 12,
                    'name'  => 'Times New Roman'
                )
            );
            $object->getActiveSheet()->getStyle("A7:M7")->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A7:M7")->applyFromArray($font);
            $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
            $object->getActiveSheet()->getStyle('A7:M7')->getAlignment()->setWrapText(true);

            // Set properties
            $object->getProperties()->setCreator($this->session->userdata('first_name'))
                ->setLastModifiedBy($this->session->userdata('first_name'))
                ->setCategory("Approve by ");
            // Add some data
            $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('M')->setWidth(20);

            $object->getActiveSheet()->mergeCells('A1:M1');
            $object->getActiveSheet()->mergeCells('A2:M2');
            $object->getActiveSheet()->mergeCells('A3:M3');
            $object->getActiveSheet()->mergeCells('A4:M4');
            $object->getActiveSheet()->mergeCells('A5:M5');

            $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
            $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

            $object->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('first_name'))
                ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                ->setCellValue('A4', 'Terminal Peti Kemas')
                ->setCellValue('A5', 'Laporan Transaksi Air Darat Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'Nama Pengguna Jasa')
                ->setCellValue('C7', 'Nama Pemohon')
                ->setCellValue('D7', 'Alamat')
                ->setCellValue('E7', 'No Telepon')
                ->setCellValue('F7', 'Tanggal Transaksi')
                ->setCellValue('G7', 'Tanggal Waktu Pengantaran')
                ->setCellValue('H7', 'Waktu Mulai Pengantaran')
                ->setCellValue('I7', 'Waktu Selesai Pengantaran')
                ->setCellValue('J7', 'Lama Pengantaran (Jam)')
                ->setCellValue('K7', 'Tarif (Rp.)')
                ->setCellValue('L7', 'Total Permintaan (Ton)')
                ->setCellValue('M7', 'Total Pembayaran (Rp.)')
            ;
            $no=0;
            //add data
            $counter=8;
            $total = 0;
            $ton = 0;
            $ex = $object->setActiveSheetIndex(0);
            foreach($result as $row){
                $lama_pengantaran = "";
                $no++;
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("M".$counter)->applyFromArray($style);

                if($row->diskon != NULL || $row->diskon != 0){
                    $row->tarif -= $row->tarif * $row->diskon/100;
                    $total_pembayaran = $row->tarif * $row->total_permintaan ;
                }
                else{
                    $total_pembayaran = $row->tarif * $row->total_permintaan;
                }

                $waktu_awal = mktime(date("H",strtotime($row->waktu_mulai_pengantaran)),date("i",strtotime($row->waktu_mulai_pengantaran)),date("s",strtotime($row->waktu_mulai_pengantaran)),date("m",strtotime($row->waktu_mulai_pengantaran)),date("d",strtotime($row->waktu_mulai_pengantaran)),date("y",strtotime($row->waktu_mulai_pengantaran)));
                $waktu_akhir = mktime(date("H",strtotime($row->waktu_selesai_pengantaran)),date("i",strtotime($row->waktu_selesai_pengantaran)),date("s",strtotime($row->waktu_selesai_pengantaran)),date("m",strtotime($row->waktu_selesai_pengantaran)),date("d",strtotime($row->waktu_selesai_pengantaran)),date("y",strtotime($row->waktu_selesai_pengantaran)) );

                if($row->waktu_mulai_pengantaran == NULL){
                    $format_jam_awal = " ";
                    $lama_pengantaran = " ";
                    if($row->waktu_selesai_pengantaran == NULL){
                        $format_jam_akhir = " ";
                    }
                }
                else if($row->waktu_selesai_pengantaran == NULL){
                    $format_jam_akhir = " ";
                    $lama_pengantaran = " ";
                }
                else{
                    $lama_pengantaran = round((($waktu_akhir - $waktu_awal) % 86400)/3600,2);
                    $format_jam_awal = date("d-m-y H:i:s",strtotime($row->waktu_mulai_pengantaran));
                    $format_jam_akhir = date("d-m-y H:i:s",strtotime($row->waktu_selesai_pengantaran));
                }

                if($lama_pengantaran > 1){
                    $lama_pengantaran .= " Jam";
                }
                else {
                    $lama_pengantaran = $lama_pengantaran * 60;
                    if ($lama_pengantaran > 1){
                        $lama_pengantaran .= " Menit";
                    }
                    else {
                        $lama_pengantaran = $lama_pengantaran * 60;
                        $lama_pengantaran .= " Detik";
                    }
                }

                if($row->batal_kwitansi == 0){
                    $total += $total_pembayaran;
                    $ton += $row->total_permintaan;
                }

                $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));
                $format_tgl_pengantaran = date('d-m-Y H:i:s', strtotime($row->tgl_perm_pengantaran ));

                $ex->setCellValue("A".$counter,"$no");
                $ex->setCellValue("B".$counter,"$row->nama_pengguna_jasa");
                $ex->setCellValue("C".$counter,"$row->nama_pemohon");
                $ex->setCellValue("D".$counter,"$row->alamat");
                $ex->setCellValue("E".$counter,"$row->no_telp");
                $ex->setCellValue("F".$counter,"$format_tgl");
                $ex->setCellValue("G".$counter,"$format_tgl_pengantaran");
                $ex->setCellValue("H".$counter,"$format_jam_awal");
                $ex->setCellValue("I".$counter,"$format_jam_akhir");
                $ex->setCellValue("J".$counter,"$lama_pengantaran");
                $ex->setCellValue("K".$counter,"$row->tarif");
                $ex->setCellValue("L".$counter,"$row->total_permintaan");
                $ex->setCellValue("M".$counter,"$total_pembayaran");
                $counter=$counter+1;
            }
            $object->getActiveSheet()->mergeCells('A'.$counter.':K'.$counter);
            $object->getActiveSheet()->getStyle("A".$counter.":M".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("M".$counter)->applyFromArray($font);

            $ex->setCellValue("A".$counter,"Total");
            $ex->setCellValue("L".$counter,"$ton");
            $ex->setCellValue("M".$counter,"$total");
            // Rename sheet
            $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Darat');

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $object->setActiveSheetIndex(0);

            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan_Transaksi_Darat_periode_'.$tgl_awal.'_'.$tgl_akhir.'.xlsx"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
            $objWriter->save('php://output');
        }
        else{
            $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"darat");

            // Create new PHPExcel object
            $object = new PHPExcel();
            $style = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                ),
                'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $font = array(
                'font'  => array(
                    'bold'  => true,
                    'size'  => 12,
                    'name'  => 'Times New Roman'
                )
            );
            $object->getActiveSheet()->getStyle("A7:L7")->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A7:L7")->applyFromArray($font);
            $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
            $object->getActiveSheet()->getStyle('A7:L7')->getAlignment()->setWrapText(true);

            // Set properties
            $object->getProperties()->setCreator($this->session->userdata('first_name'))
                ->setLastModifiedBy($this->session->userdata('first_name'))
                ->setCategory("Approve by ");
            // Add some data
            $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('L')->setWidth(20);

            $object->getActiveSheet()->mergeCells('A1:L1');
            $object->getActiveSheet()->mergeCells('A2:L2');
            $object->getActiveSheet()->mergeCells('A3:L3');
            $object->getActiveSheet()->mergeCells('A4:L4');
            $object->getActiveSheet()->mergeCells('A5:L5');

            $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
            $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

            $object->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('first_name'))
                ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                ->setCellValue('A4', 'Terminal Peti Kemas')
                ->setCellValue('A5', 'Laporan Transaksi Air Darat Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'Nama Pengguna Jasa')
                ->setCellValue('C7', 'Nama Pemohon')
                ->setCellValue('D7', 'Alamat')
                ->setCellValue('E7', 'No Telepon')
                ->setCellValue('F7', 'Tanggal Transaksi')
                ->setCellValue('G7', 'Tanggal Waktu Pengantaran')
                ->setCellValue('H7', 'Waktu Mulai Pengantaran')
                ->setCellValue('I7', 'Waktu Selesai Pengantaran')
                ->setCellValue('J7', 'Lama Pengantaran (Jam)')
                ->setCellValue('K7', 'Total Permintaan (Ton)')
                ->setCellValue('L7', 'Total Pembayaran (Rp.)')
            ;
            $no=0;
            //add data
            $counter=8;
            $total = 0;
            $ton = 0;
            $ex = $object->setActiveSheetIndex(0);
            foreach($result as $row){
                $lama_pengantaran = "";
                $no++;
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($style);

                if($row->diskon != NULL || $row->diskon != 0){
                    $row->tarif -= $row->tarif * $row->diskon/100;
                    $total_pembayaran = $row->tarif * $row->total_permintaan ;
                }
                else{
                    $total_pembayaran = $row->tarif * $row->total_permintaan;
                }

                $waktu_awal = mktime(date("H",strtotime($row->waktu_mulai_pengantaran)),date("i",strtotime($row->waktu_mulai_pengantaran)),date("s",strtotime($row->waktu_mulai_pengantaran)),date("m",strtotime($row->waktu_mulai_pengantaran)),date("d",strtotime($row->waktu_mulai_pengantaran)),date("y",strtotime($row->waktu_mulai_pengantaran)));
                $waktu_akhir = mktime(date("H",strtotime($row->waktu_selesai_pengantaran)),date("i",strtotime($row->waktu_selesai_pengantaran)),date("s",strtotime($row->waktu_selesai_pengantaran)),date("m",strtotime($row->waktu_selesai_pengantaran)),date("d",strtotime($row->waktu_selesai_pengantaran)),date("y",strtotime($row->waktu_selesai_pengantaran)) );

                if($row->waktu_mulai_pengantaran == NULL){
                    $lama_pengantaran = " ";
                    $format_jam_awal = " ";
                    if($row->waktu_selesai_pengantaran == NULL){
                        $format_jam_akhir = " ";
                    }
                } else if($row->waktu_selesai_pengantaran == NULL){
                    $format_jam_akhir = " ";
                    $lama_pengantaran = " ";
                } else{
                    $lama_pengantaran = round((($waktu_akhir - $waktu_awal) % 86400)/3600,2);
                    $format_jam_awal = date("d-m-y H:i:s",strtotime($row->waktu_mulai_pengantaran));
                    $format_jam_akhir = date("d-m-y H:i:s",strtotime($row->waktu_selesai_pengantaran));
                }

                if($lama_pengantaran > 1){
                    $lama_pengantaran .= " Jam";
                }
                else {
                    $lama_pengantaran = $lama_pengantaran * 60;

                    if ($lama_pengantaran > 1){
                        $lama_pengantaran .= " Menit";
                    }
                    else {
                        $lama_pengantaran = $lama_pengantaran * 60;
                        $lama_pengantaran .= " Detik";
                    }
                }

                if($row->batal_kwitansi == 0){
                    $total += $total_pembayaran;
                    $ton += $row->total_permintaan;
                }

                $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));
                $format_tgl_pengantaran = date('d-m-Y H:i:s', strtotime($row->tgl_perm_pengantaran ));

                $ex->setCellValue("A".$counter,"$no");
                $ex->setCellValue("B".$counter,"$row->nama_pengguna_jasa");
                $ex->setCellValue("C".$counter,"$row->nama_pemohon");
                $ex->setCellValue("D".$counter,"$row->alamat");
                $ex->setCellValue("E".$counter,"$row->no_telp");
                $ex->setCellValue("F".$counter,"$format_tgl");
                $ex->setCellValue("G".$counter,"$format_tgl_pengantaran");
                $ex->setCellValue("H".$counter,"$format_jam_awal");
                $ex->setCellValue("I".$counter,"$format_jam_akhir");
                $ex->setCellValue("J".$counter,"$lama_pengantaran");
                $ex->setCellValue("K".$counter,"$row->total_permintaan");
                $ex->setCellValue("L".$counter,"$total_pembayaran");
                $counter=$counter+1;
            }
            $object->getActiveSheet()->mergeCells('A'.$counter.':J'.$counter);
            $object->getActiveSheet()->getStyle("A".$counter.":L".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($font);

            $ex->setCellValue("A".$counter,"Total");
            $ex->setCellValue("K".$counter,"$ton");
            $ex->setCellValue("L".$counter,"$total");
            // Rename sheet
            $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Darat');

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $object->setActiveSheetIndex(0);

            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="Laporan_Transaksi_Darat_periode_'.$_GET['id'].'_'.$_GET['id2'].'.xlsx"');
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
            $objWriter->save('php://output');
        }

    }

    public function excelLaut($tgl_awal,$tgl_akhir) {
        // Create new PHPExcel object
        $object = new PHPExcel();
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $font = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Times New Roman'
            )
        );

        // Set properties
        $object->getProperties()->setCreator($this->session->userdata('first_name'))
            ->setLastModifiedBy($this->session->userdata('first_name'))
            ->setCategory("Approve by ");
        // Add some data
        if($this->session->userdata('role_name') == 'keuangan'){
            $object->getActiveSheet()->getStyle("A7:M7")->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A7:M7")->applyFromArray($font);
            $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
            $object->getActiveSheet()->getStyle('A7:M7')->getAlignment()->setWrapText(true);
            $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"laut");

            $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('M')->setWidth(20);

            $object->getActiveSheet()->mergeCells('A1:M1');
            $object->getActiveSheet()->mergeCells('A2:M2');
            $object->getActiveSheet()->mergeCells('A3:M3');
            $object->getActiveSheet()->mergeCells('A4:M4');
            $object->getActiveSheet()->mergeCells('A5:M5');

            $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
            $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

            $object->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('first_name'))
                ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                ->setCellValue('A4', 'Terminal Peti Kemas')
                ->setCellValue('A5', 'Laporan Transaksi Air Kapal Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'NO Nota')
                ->setCellValue('C7', 'NO Faktur')
                ->setCellValue('D7', 'ID Vessel')
                ->setCellValue('E7', 'Nama Vessel')
                ->setCellValue('F7', 'Voy No')
                ->setCellValue('G7', 'Tipe Kapal')
                ->setCellValue('H7', 'Nama Perusahaan')
                ->setCellValue('I7', 'Tanggal Transaksi')
                ->setCellValue('J7', 'Tarif (Rp.)')
                ->setCellValue('K7', 'Total Permintaan (Ton)')
                ->setCellValue('L7', 'Realisasi Pengisian (Ton)')
                ->setCellValue('M7', 'Total Pembayaran (Rp.)')
            ;
            $no=0;
            //add data
            $counter=8;
            $total = 0;
            $ton = 0;
            $ton_realisasi = 0;
            $total_realisasi=0;
            $ex = $object->setActiveSheetIndex(0);
            foreach($result as $row){
                $no++;
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("M".$counter)->applyFromArray($style);


                if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                    $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;

                    if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                        $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                        if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                            $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        } else{
                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        }
                    }
                    else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                        $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                    }
                    else {
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                    }
                }
                else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                    $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                    if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                        $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                    } else {
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                    }
                }
                else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                    $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                    }
                else{
                    $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                }

                if($row->diskon != NULL || $row->diskon != 0){
                    $row->tarif -= $row->tarif * $row->diskon/100;
                    $total_pembayaran = $row->tarif * $realisasi;
                } else{
                    $total_pembayaran = $row->tarif * $realisasi;
                }

                if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                    $total_pembayaran += 3000;
                } else if($total_pembayaran > 1000000){
                    $total_pembayaran += 6000;
                } else{
                    $total_pembayaran += 0;
                }

                if($row->tipe_kapal == 8)
                    $row->tipe_kapal = "Peti Kemas";
                else
                    $row->tipe_kapal = "Tongkang";

                $total += $total_pembayaran;
                $ton += $row->total_permintaan;
                $ton_realisasi += $realisasi;
                $total_realisasi += $realisasi;
                $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));

                $ex->setCellValue("A".$counter,"$no");
                $ex->setCellValue("B".$counter,"$row->no_nota");
                $ex->setCellValue("C".$counter,"$row->no_faktur");
                $ex->setCellValue("D".$counter,"$row->id_vessel");
                $ex->setCellValue("E".$counter,"$row->nama_vessel");
                $ex->setCellValue("F".$counter,"$row->voy_no");
                $ex->setCellValue("G".$counter,"$row->tipe_kapal");
                $ex->setCellValue("H".$counter,"$row->nama_agent");
                $ex->setCellValue("I".$counter,"$format_tgl");
                $ex->setCellValue("J".$counter,"$row->tarif");
                $ex->setCellValue("K".$counter,"$row->total_permintaan");
                $ex->setCellValue("L".$counter,"$realisasi");
                $ex->setCellValue("M".$counter,"$total_pembayaran");
                $counter=$counter+1;
            }
            $object->getActiveSheet()->mergeCells('A'.$counter.':I'.$counter);
            $object->getActiveSheet()->getStyle("A".$counter.":M".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("M".$counter)->applyFromArray($font);

            $ex->setCellValue("A".$counter,"Total");
            $ex->setCellValue("K".$counter,"$ton");
            $ex->setCellValue("L".$counter,"$total_realisasi");
            $ex->setCellValue("M".$counter,"$total");
        }
        else if($this->session->userdata('role_name') == 'operasi'){
            $object->getActiveSheet()->getStyle("A7:K7")->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A7:K7")->applyFromArray($font);
            $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
            $object->getActiveSheet()->getStyle('A7:K7')->getAlignment()->setWrapText(true);

            $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"laut_operasi");

            $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);

            $object->getActiveSheet()->mergeCells('A1:K1');
            $object->getActiveSheet()->mergeCells('A2:K2');
            $object->getActiveSheet()->mergeCells('A3:K3');
            $object->getActiveSheet()->mergeCells('A4:K4');
            $object->getActiveSheet()->mergeCells('A5:K5');

            $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
            $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

            $object->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('first_name'))
                ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                ->setCellValue('A4', 'Terminal Peti Kemas')
                ->setCellValue('A5', 'Laporan Transaksi Air Kapal Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'ID Vessel')
                ->setCellValue('C7', 'Nama Vessel')
                ->setCellValue('D7', 'Voy No')
                ->setCellValue('E7', 'Tipe Kapal')
                ->setCellValue('F7', 'Nama Perusahaan')
                ->setCellValue('G7', 'Tanggal Transaksi')
                ->setCellValue('H7', 'Tarif (Rp.)')
                ->setCellValue('I7', 'Total Permintaan (Ton)')
                ->setCellValue('J7', 'Realisasi Pengisian (Ton)')
                ->setCellValue('K7', 'Total Pembayaran (Rp.)')
            ;
            $no=0;
            //add data
            $counter=8;
            $total = 0;
            $ton = 0;
            $ton_realisasi = 0;
            $ex = $object->setActiveSheetIndex(0);
            foreach($result as $row){
                $no++;
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($style);


                if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                    $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;

                    if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                        $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                        if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                            $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        } else{
                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        }
                    }
                    else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                        $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                    }
                    else {
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                    }
                }
                else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                    $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;

                    if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                        $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                    } else {
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                    }
                }
                else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                    $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                }
                else{
                    $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                }

                if($row->diskon != NULL || $row->diskon != 0){
                    $row->tarif -= $row->tarif * $row->diskon/100;
                    $total_pembayaran = $row->tarif * $realisasi;
                } else{
                    $total_pembayaran = $row->tarif * $realisasi;
                }

                if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                    $total_pembayaran += 3000;
                } else if($total_pembayaran > 1000000){
                    $total_pembayaran += 6000;
                } else{
                    $total_pembayaran += 0;
                }

                if($row->tipe_kapal == 8)
                    $row->tipe_kapal = "Peti Kemas";
                else
                    $row->tipe_kapal = "Tongkang";

                $total += $total_pembayaran;
                $ton += $row->total_permintaan;
                $ton_realisasi += $realisasi;
                $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));

                $ex->setCellValue("A".$counter,"$no");
                $ex->setCellValue("B".$counter,"$row->id_vessel");
                $ex->setCellValue("C".$counter,"$row->nama_vessel");
                $ex->setCellValue("D".$counter,"$row->voy_no");
                $ex->setCellValue("E".$counter,"$row->tipe_kapal");
                $ex->setCellValue("F".$counter,"$row->nama_agent");
                $ex->setCellValue("G".$counter,"$format_tgl");
                $ex->setCellValue("H".$counter,"$row->tarif");
                $ex->setCellValue("I".$counter,"$row->total_permintaan");
                $ex->setCellValue("J".$counter,"$realisasi");
                $ex->setCellValue("K".$counter,"$total_pembayaran");
                $counter=$counter+1;
            }
            $object->getActiveSheet()->mergeCells('A'.$counter.':H'.$counter);
            $object->getActiveSheet()->getStyle("A".$counter.":K".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($font);

            $ex->setCellValue("A".$counter,"Total");
            $ex->setCellValue("I".$counter,"$ton");
            $ex->setCellValue("J".$counter,"$ton_realisasi");
            $ex->setCellValue("K".$counter,"$total");

        }
        else {
            $object->getActiveSheet()->getStyle("A7:L7")->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A7:L7")->applyFromArray($font);
            $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
            $object->getActiveSheet()->getStyle('A7:L7')->getAlignment()->setWrapText(true);

            $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"laut_operasi");

            $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('L')->setWidth(20);

            $object->getActiveSheet()->mergeCells('A1:L1');
            $object->getActiveSheet()->mergeCells('A2:L2');
            $object->getActiveSheet()->mergeCells('A3:L3');
            $object->getActiveSheet()->mergeCells('A4:L4');
            $object->getActiveSheet()->mergeCells('A5:L5');

            $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
            $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

            $object->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('first_name'))
                ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                ->setCellValue('A4', 'Terminal Peti Kemas')
                ->setCellValue('A5', 'Laporan Transaksi Air Kapal Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'ID Vessel')
                ->setCellValue('C7', 'Nama Vessel')
                ->setCellValue('D7', 'Voy No')
                ->setCellValue('E7', 'Tipe Kapal')
                ->setCellValue('F7', 'Nama Perusahaan')
                ->setCellValue('G7', 'Tanggal Transaksi')
                ->setCellValue('H7', 'Total Permintaan (Ton)')
                ->setCellValue('I7', 'Flow Meter Awal')
                ->setCellValue('J7', 'Flow Meter Akhir')
                ->setCellValue('K7', 'Realisasi Pengisian (Ton)')
                ->setCellValue('L7', 'Total Pembayaran (Rp.)')
            ;
            $no=0;
            //add data
            $counter=8;
            $total = 0;
            $ton = 0;
            $ton_realisasi = 0;
            $ex = $object->setActiveSheetIndex(0);
            foreach($result as $row){
                $no++;
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($style);

                if($row->flowmeter_awal == NULL || $row->flowmeter_awal == '0'){
                    $flowmeter_awal = "0";
                }
                else{
                    $flowmeter_awal = $row->flowmeter_awal;
                }

                if($row->flowmeter_akhir == NULL || $row->flowmeter_akhir == '0'){
                    $flowmeter_akhir = "0";
                }
                else{
                    $flowmeter_akhir = $row->flowmeter_akhir;
                }

                if($row->flowmeter_awal_2 == NULL || $row->flowmeter_awal_2 == '0'){
                    $flowmeter_awal_2 = "0";
                }
                else{
                    $flowmeter_awal_2 = $row->flowmeter_awal_2;
                }

                if($row->flowmeter_akhir_2 == NULL || $row->flowmeter_akhir_2 == '0'){
                    $flowmeter_akhir_2 = "0";
                }
                else{
                    $flowmeter_akhir_2 = $row->flowmeter_akhir_2;
                }

                if($row->flowmeter_awal_3 == NULL || $row->flowmeter_awal_3 == '0'){
                    $flowmeter_awal_3 = "0";
                }
                else{
                    $flowmeter_awal_3 = $row->flowmeter_awal_3;
                }

                if($row->flowmeter_akhir_3 == NULL || $row->flowmeter_akhir_3 == '0'){
                    $flowmeter_akhir_3 = "0";
                }
                else{
                    $flowmeter_akhir_3 = $row->flowmeter_akhir_3;
                }

                if($row->flowmeter_awal_4 == NULL || $row->flowmeter_awal_4 == '0'){
                    $flowmeter_awal_4 = "0";
                }
                else{
                    $flowmeter_awal_4 = $row->flowmeter_awal_4;
                }

                if($row->flowmeter_akhir_4 == NULL || $row->flowmeter_akhir_4 == '0'){
                    $flowmeter_akhir_4 = "0";
                }
                else{
                    $flowmeter_akhir_4 = $row->flowmeter_akhir_4;
                }

                if($row->flowmeter_akhir_4 != NULL && $row->flowmeter_awal_4 != NULL){
                    $realisasi = $row->flowmeter_akhir_4 - $row->flowmeter_awal_4;
                    $flow_sebelum = $flowmeter_awal_4;
                    $flow_sesudah = $flowmeter_akhir_4;

                    if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                        $realisasi += $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                        $flow_sebelum .= " , ".$flowmeter_awal_3;
                        $flow_sesudah .= " , ".$flowmeter_akhir_3;

                        if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                            $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                            $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                            $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                        } else{
                            $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                            $flow_sebelum .= " , ".$flowmeter_awal;
                            $flow_sesudah .= " , ".$flowmeter_akhir;
                        }
                    }
                    else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                        $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                        $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                    }
                    else {
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        $flow_sebelum .= " , ".$flowmeter_awal;
                        $flow_sesudah .= " , ".$flowmeter_akhir;
                    }
                }
                else if($row->flowmeter_akhir_3 != NULL && $row->flowmeter_awal_3 != NULL){
                    $realisasi = $row->flowmeter_akhir_3 - $row->flowmeter_awal_3;
                    $flow_sebelum = $flowmeter_awal_3;
                    $flow_sesudah = $flowmeter_akhir_3;

                    if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                        $realisasi += $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        $flow_sebelum .= " , ".$flowmeter_awal_2." , ".$flowmeter_awal;
                        $flow_sesudah .= " , ".$flowmeter_akhir_2." , ".$flowmeter_akhir;
                    } else {
                        $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                        $flow_sebelum .= " , ".$flowmeter_awal;
                        $flow_sesudah .= " , ".$flowmeter_akhir;
                    }
                }
                else if($row->flowmeter_akhir_2 != NULL && $row->flowmeter_awal_2 != NULL){
                    $realisasi = $row->flowmeter_akhir_2 - $row->flowmeter_awal_2;
                    $realisasi += $row->flowmeter_akhir - $row->flowmeter_awal;
                    $flow_sebelum = $flowmeter_awal_2." , ".$flowmeter_awal;
                    $flow_sesudah = $flowmeter_akhir_2." , ".$flowmeter_akhir;
                }
                else{
                    $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;
                    $flow_sebelum = $flowmeter_awal;
                    $flow_sesudah = $flowmeter_akhir;
                }

                if($row->diskon != NULL || $row->diskon != 0){
                    $row->tarif -= $row->tarif * $row->diskon/100;
                    $total_pembayaran = $row->tarif * $realisasi;
                } else{
                    $total_pembayaran = $row->tarif * $realisasi;
                }

                if($total_pembayaran >= 250000 && $total_pembayaran <= 1000000){
                    $total_pembayaran += 3000;
                } else if($total_pembayaran > 1000000){
                    $total_pembayaran += 6000;
                } else{
                    $total_pembayaran += 0;
                }

                if($row->tipe_kapal == 8)
                    $row->tipe_kapal = "Peti Kemas";
                else
                    $row->tipe_kapal = "Tongkang";

                $total += $total_pembayaran;
                $ton += $row->total_permintaan;
                $ton_realisasi += $realisasi;
                $format_tgl = date('d-m-Y H:i:s', strtotime($row->tgl_transaksi ));

                $ex->setCellValue("A".$counter,"$no");
                $ex->setCellValue("B".$counter,"$row->id_vessel");
                $ex->setCellValue("C".$counter,"$row->nama_vessel");
                $ex->setCellValue("D".$counter,"$row->voy_no");
                $ex->setCellValue("E".$counter,"$row->tipe_kapal");
                $ex->setCellValue("F".$counter,"$row->nama_agent");
                $ex->setCellValue("G".$counter,"$format_tgl");
                $ex->setCellValue("H".$counter,"$row->total_permintaan");
                $ex->setCellValue("I".$counter,"$flow_sebelum");
                $ex->setCellValue("J".$counter,"$flow_sesudah");
                $ex->setCellValue("K".$counter,"$realisasi");
                $ex->setCellValue("L".$counter,"$total_pembayaran");
                $counter=$counter+1;
            }
            $object->getActiveSheet()->mergeCells('A'.$counter.':G'.$counter);
            $object->getActiveSheet()->getStyle("A".$counter.":L".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($font);

            $ex->setCellValue("A".$counter,"Total");
            $ex->setCellValue("H".$counter,"$ton");
            $ex->setCellValue("K".$counter,"$ton_realisasi");
            $ex->setCellValue("L".$counter,"$total");
        }
        // Rename sheet
        $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Kapal');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $object->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Transaksi_Kapal_periode_'.$tgl_awal.'_'.$tgl_akhir.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function excelRuko($tgl_awal,$tgl_akhir) {
        $ton = "";
        $total_penggunaan = "";

        // Create new PHPExcel object
        $object = new PHPExcel();
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $font = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Times New Roman'
            )
        );

        $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($style);
        $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($font);
        $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
        $object->getActiveSheet()->getStyle('A7:J7')->getAlignment()->setWrapText(true);

        // Set properties
        $object->getProperties()->setCreator($this->session->userdata('first_name'))
            ->setLastModifiedBy($this->session->userdata('first_name'))
            ->setCategory("Approve by ");
        // Add some data
        if($this->session->userdata('role_name') == "keuangan"){
            $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"ruko_keuangan");

            $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);

            $object->getActiveSheet()->mergeCells('A1:J1');
            $object->getActiveSheet()->mergeCells('A2:J2');
            $object->getActiveSheet()->mergeCells('A3:J3');
            $object->getActiveSheet()->mergeCells('A4:J4');
            $object->getActiveSheet()->mergeCells('A5:J5');

            $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
            $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

            $object->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('first_name'))
                ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                ->setCellValue('A4', 'Terminal Peti Kemas')
                ->setCellValue('A5', 'Laporan Transaksi Air Ruko Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'No Invoice')
                ->setCellValue('C7', 'No Nota')
                ->setCellValue('D7', 'No Faktur')
                ->setCellValue('E7', 'Nama Tenant')
                ->setCellValue('F7', 'No Perjanjian')
                ->setCellValue('G7', 'Alamat')
                ->setCellValue('H7', 'No Telepon')
                ->setCellValue('I7', 'Total Penggunaan')
                ->setCellValue('J7', 'Total Pembayaran (Rp.)')
            ;
            $no=0;
            //add data
            $counter=8;
            $ton_total = 0;
            $total_pembayaran =0;
            $ex = $object->setActiveSheetIndex(0);

            foreach($result as $row){
                $no++;
                $data_tagihan = $this->tenant->getTagihan($tgl_awal,$tgl_akhir,$row->id_flow);
                $i = 1;
                $no_perjanjian = '';
                $ttl_awal = '';
                $ttl_akhir = '';

                $object->getActiveSheet()->getStyle("A".$counter.":I".$counter)->applyFromArray($style);

                if($data_tagihan != NULL) {
                    foreach ($data_tagihan as $data) {
                        if($data->id_ref_flowmeter == $row->id_flow) {
                            if ($i == 1 && $data->flow_hari_ini != NULL) {
                                $ttl_awal = $data->flow_hari_ini;
                            } else {
                                if ($ttl_awal == 0) {
                                    $ttl_awal = $data->flow_hari_ini;
                                }
                            }
                            if ($i == count($data_tagihan) && $data->flow_hari_ini != NULL) {
                                $ttl_akhir = $data->flow_hari_ini;
                            }
                            $i++;
                        }
                        else {
                            $i = 1;
                        }
                    }

                    $ton_koma = $ttl_akhir - $ttl_awal;
                    $ton_total += $ton_koma;
                    $ton = $this->Koma($ton_koma);
                    $tarif = $row->tarif;
                    $diskon = $row->diskon;
                } else{
                    $ton = 0;
                    $no_perjanjian = $row->no_perjanjian;
                    $tarif = $row->nominal;
                    $diskon = '';
                }

                if($row->id_ref_tenant == NULL){
                    if($row->diskon != NULL){
                        $pembayaran = ($row->tarif - ($row->tarif * $row->diskon/100)) * $ton_koma;
                    }
                    else{
                        $pembayaran = $row->tarif * $ton_koma;
                    }
                }
                else {
                    $date_now = strtotime(date('Y-m-d',time() ));
                    $date_kadaluarsa = strtotime($row->waktu_kadaluarsa);
                    if($date_now <= $date_kadaluarsa)
                        $pembayaran = $row->nominal;
                    else
                        $pembayaran = 0;
                }

                $total_pembayaran += $pembayaran;

                $ex->setCellValue("A".$counter,"$no");
                $ex->setCellValue("B".$counter,"$row->no_invoice");
                $ex->setCellValue("C".$counter,"$row->no_nota");
                $ex->setCellValue("D".$counter,"$row->no_faktur");
                $ex->setCellValue("E".$counter,"$row->nama_tenant");
                $ex->setCellValue("F".$counter,"$no_perjanjian");
                $ex->setCellValue("G".$counter,"$row->lokasi");
                $ex->setCellValue("H".$counter,"$row->no_telp");
                $ex->setCellValue("I".$counter,"$ton");
                $ex->setCellValue("J".$counter,"$pembayaran");

                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);

                $counter=$counter+1;
            }
            $object->getActiveSheet()->mergeCells('A'.$counter.':H'.$counter);
            $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);

            $ex->setCellValue("A".$counter,"Total");
            $ex->setCellValue("I".$counter,"$ton_total");
            $ex->setCellValue("J".$counter,"$total_pembayaran");
        }
        else{
            $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"ruko");

            $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);

            $object->getActiveSheet()->mergeCells('A1:J1');
            $object->getActiveSheet()->mergeCells('A2:J2');
            $object->getActiveSheet()->mergeCells('A3:J3');
            $object->getActiveSheet()->mergeCells('A4:J4');
            $object->getActiveSheet()->mergeCells('A5:J5');

            $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
            $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

            $object->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('first_name'))
                ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
                ->setCellValue('A4', 'Terminal Peti Kemas')
                ->setCellValue('A5', 'Laporan Transaksi Air Ruko Periode '.$tgl_awal.' s/d '.$tgl_akhir)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'ID Tenant')
                ->setCellValue('C7', 'Nama Tenant')
                ->setCellValue('D7', 'No Perjanjian')
                ->setCellValue('E7', 'Tarif')
                ->setCellValue('F7', 'Diskon')
                ->setCellValue('G7', 'Pemakaian Awal')
                ->setCellValue('H7', 'Pemakaian Akhir')
                ->setCellValue('I7', 'Total Penggunaan')
                ->setCellValue('J7', 'Total Pembayaran (Rp.)')
            ;
            $no=0;
            //add data
            $counter=8;
            $ton_total = 0;
            $total_pembayaran =0;
            $ex = $object->setActiveSheetIndex(0);

            foreach($result as $row){
                $no++;
                $data_tagihan = $this->tenant->getTagihan($tgl_awal,$tgl_akhir,$row->id_flow);
                $i = 1;
                $no_perjanjian = '';
                $ttl_awal = '';
                $ttl_akhir = '';

                $object->getActiveSheet()->getStyle("A".$counter.":I".$counter)->applyFromArray($style);
                if($data_tagihan != NULL) {
                    foreach ($data_tagihan as $data) {
                        if ($data->id_ref_flowmeter == $row->id_flow) {
                            if ($i == 1 && $data->flow_hari_ini != NULL) {
                                $ttl_awal = $data->flow_hari_ini;
                            }
                            else {
                                if ($ttl_awal == 0) {
                                    $ttl_awal = $data->flow_hari_ini;
                                }
                            }
                            if ($i == count($data_tagihan) && $data->flow_hari_ini != NULL) {
                                $ttl_akhir = $data->flow_hari_ini;
                            }
                            $i++;
                        }
                        else {
                            $i = 1;
                        }
                    }

                    $ton_koma = $ttl_akhir - $ttl_awal;
                    $ton_total += $ton_koma;
                    $ton = $this->Koma($ton_koma);
                    $tarif = $row->tarif;
                    $diskon = $row->diskon;
                } else{
                    $ton = 0;
                    $no_perjanjian = $row->no_perjanjian;
                    $tarif = $row->nominal;
                    $diskon = '';
                }

                if($row->id_ref_tenant == NULL){
                    if($row->diskon != NULL){
                        $pembayaran = ($row->tarif - ($row->tarif * $row->diskon/100)) * $ton_koma;
                    }
                    else{
                        $pembayaran = $row->tarif * $ton_koma;
                    }
                } else {
                    $date_now = strtotime(date('Y-m-d',time() ));
                    $date_kadaluarsa = strtotime($row->waktu_kadaluarsa);
                    if($date_now <= $date_kadaluarsa)
                        $pembayaran = $row->nominal;
                    else
                        $pembayaran = 0;
                }

                $total_pembayaran += $pembayaran;

                $ex->setCellValue("A".$counter,"$no");
                $ex->setCellValue("B".$counter,"$row->id_flowmeter");
                $ex->setCellValue("C".$counter,"$row->nama_tenant");
                $ex->setCellValue("D".$counter,"$no_perjanjian");
                $ex->setCellValue("E".$counter,"$tarif");
                $ex->setCellValue("F".$counter,"$diskon");
                $ex->setCellValue("G".$counter,"$ttl_awal");
                $ex->setCellValue("H".$counter,"$ttl_akhir");
                $ex->setCellValue("I".$counter,"$ton");
                $ex->setCellValue("J".$counter,"$pembayaran");

                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);

                $counter=$counter+1;
            }
            $object->getActiveSheet()->mergeCells('A'.$counter.':H'.$counter);
            $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);

            $ex->setCellValue("A".$counter,"Total");
            $ex->setCellValue("I".$counter,"$ton_total");
            $ex->setCellValue("J".$counter,"$total_pembayaran");
        }

        // Rename sheet
        $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Ruko');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $object->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Transaksi_Ruko_periode_'.$tgl_awal.'_'.$tgl_akhir.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function excelFlow($tgl_awal,$tgl_akhir) {
        // Create new PHPExcel object
        $object = new PHPExcel();
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $font = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Times New Roman'
            )
        );

        $object->getActiveSheet()->getStyle("A7:E7")->applyFromArray($style);
        $object->getActiveSheet()->getStyle("A7:E7")->applyFromArray($font);
        $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
        $object->getActiveSheet()->getStyle('A7:E7')->getAlignment()->setWrapText(true);

        // Set properties
        $object->getProperties()->setCreator($this->session->userdata('first_name'))
            ->setLastModifiedBy($this->session->userdata('first_name'))
            ->setCategory("Approve by ");
        // Add some data
        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"flow");

        $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $object->getActiveSheet()->getColumnDimension('E')->setWidth(15);

        $object->getActiveSheet()->mergeCells('A1:E1');
        $object->getActiveSheet()->mergeCells('A2:E2');
        $object->getActiveSheet()->mergeCells('A3:E3');
        $object->getActiveSheet()->mergeCells('A4:E4');
        $object->getActiveSheet()->mergeCells('A5:E5');

        $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

        $object->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('first_name'))
            ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
            ->setCellValue('A4', 'Terminal Peti Kemas')
            ->setCellValue('A5', 'Laporan Pencatatan Flow Meter Periode '.$tgl_awal.' s/d '.$tgl_akhir)
            ->setCellValue('A7', 'No')
            ->setCellValue('B7', 'ID Flow Meter')
            ->setCellValue('C7', 'Nama Flow Meter')
            ->setCellValue('D7', 'Nilai Flow')
            ->setCellValue('E7', 'Issued By')
        ;
        $no=0;
        //add data
        $counter=8;
        $ex = $object->setActiveSheetIndex(0);

        foreach($result as $row){
            $no++;
            $data_tagihan = $this->tenant->getFlow($tgl_awal,$tgl_akhir,$row->id_flow);
            $i = 1;
            $ttl_akhir=0;

            $object->getActiveSheet()->getStyle("A".$counter.":E".$counter)->applyFromArray($style);

            if($data_tagihan != NULL) {
                foreach($data_tagihan as $data) {
                    if($data->id_ref_flowmeter == $row->id_flow){
                        if($i == 1 && $data->flow_hari_ini != NULL){
                            $ttl_akhir = $data->flow_hari_ini;
                        }else{
                            if($ttl_akhir == 0){
                                $ttl_akhir = $data->flow_hari_ini;
                            }
                        }
                        if($i == count($data_tagihan) && $data->flow_hari_ini != NULL){
                            $ttl_akhir = $data->flow_hari_ini;
                        }
                        $i++;
                    }else{
                        $i=1;
                    }
                }
            }

            $ex->setCellValue("A".$counter,"$no");
            $ex->setCellValue("B".$counter,"$row->id_flowmeter");
            $ex->setCellValue("C".$counter,"$row->nama_flowmeter");
            $ex->setCellValue("D".$counter,"$ttl_akhir");
            $ex->setCellValue("E".$counter,"$row->issued_by");

            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
            $counter=$counter+1;
        }

        // Rename sheet
        $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Flow');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $object->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Transaksi_Flow_periode_'.$tgl_awal.'_'.$tgl_akhir.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function excelPerFlow($tgl_awal,$tgl_akhir,$id) {
        // Create new PHPExcel object
        $object = new PHPExcel();
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $font = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Times New Roman'
            )
        );

        $judul = $this->tenant->getDataFlowmeter($tgl_awal,$tgl_akhir,$id)->nama_flowmeter;
        $id_flow = $this->tenant->getDataFlowmeter($tgl_awal,$tgl_akhir,$id)->id_flowmeter;

        $object->getActiveSheet()->getStyle("A7:D7")->applyFromArray($style);
        $object->getActiveSheet()->getStyle("A7:D7")->applyFromArray($font);
        $object->getActiveSheet()->getStyle("A1:A5")->applyFromArray($font);
        $object->getActiveSheet()->getStyle('A7:D7')->getAlignment()->setWrapText(true);

        // Set properties
        $object->getProperties()->setCreator($this->session->userdata('first_name'))
            ->setLastModifiedBy($this->session->userdata('first_name'))
            ->setCategory("Approve by ");
        // Add some data
        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"per_flow",$id);

        $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('D')->setWidth(15);

        $object->getActiveSheet()->mergeCells('A1:E1');
        $object->getActiveSheet()->mergeCells('A2:E2');
        $object->getActiveSheet()->mergeCells('A4:E4');
        $object->getActiveSheet()->mergeCells('A5:J5');

        $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

        $object->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('first_name'))
            ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
            ->setCellValue('A4', 'Terminal Peti Kemas')
            ->setCellValue('A5', 'Laporan Pencatatan Flow Meter '.$judul.' Periode '.$tgl_awal.' s/d '.$tgl_akhir)
            ->setCellValue('A7', 'No')
            ->setCellValue('B7', 'Waktu Perekaman')
            ->setCellValue('C7', 'Issued By')
            ->setCellValue('D7', 'Nilai Flow')
        ;
        $no=0;
        //add data
        $counter=8;
        $ex = $object->setActiveSheetIndex(0);
        $ttl_akhir = 0;
        $ttl_awal = 0;
        $i = 1;
        
        foreach($result as $row){
            $data_tagihan = $this->tenant->getFlow($tgl_awal, $tgl_akhir, $row->id_flow);

            $no++;

            if($data_tagihan != NULL){
                foreach ($data_tagihan as $data) {
                    if ($data->id_ref_flowmeter == $row->id_flow) {
                        if ($i == 1 && $data->flow_hari_ini != NULL) {
                            $ttl_awal = $data->flow_hari_ini;
                        }
                        else {
                            if ($ttl_awal == 0) {
                                $ttl_awal = $data->flow_hari_ini;
                            }
                        }
                        if ($i == count($data_tagihan) && $data->flow_hari_ini != NULL) {
                            $ttl_akhir = $data->flow_hari_ini;
                        }
                        $i++;
                    }
                    else {
                        $i = 1;
                    }
                }
            }

            $object->getActiveSheet()->getStyle("A".$counter.":D".$counter)->applyFromArray($style);

            $ex->setCellValue("A".$counter,"$no");
            $ex->setCellValue("B".$counter,"$row->waktu_perekaman");
            $ex->setCellValue("C".$counter,"$row->issued_by");
            $ex->setCellValue("D".$counter,"$row->flow_hari_ini");

            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
            $counter=$counter+1;
        }

        $total_pemakaian = $ttl_akhir - $ttl_awal;

        $object->getActiveSheet()->mergeCells('A'.$counter.':C'.$counter);
        $object->getActiveSheet()->getStyle("A".$counter.":D".$counter)->applyFromArray($style);
        $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
        $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($font);

        $ex->setCellValue("A".$counter,"Total Pemakaian");
        $ex->setCellValue("D".$counter,"$total_pemakaian");
        // Rename sheet
        $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Flow');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $object->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Transaksi_'.$id_flow.'_periode_'.$tgl_awal.'_'.$tgl_akhir.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function excelSumur($tgl_awal,$tgl_akhir) {
        // Create new PHPExcel object
        $object = new PHPExcel();
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $font = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Times New Roman'
            )
        );

        $object->getActiveSheet()->getStyle("A7:O7")->applyFromArray($style);
        $object->getActiveSheet()->getStyle("A7:O7")->applyFromArray($font);
        $object->getActiveSheet()->getStyle("A1:O5")->applyFromArray($font);
        $object->getActiveSheet()->getStyle('A7:O7')->getAlignment()->setWrapText(true);

        // Set properties
        $object->getProperties()->setCreator($this->session->userdata('first_name'))
            ->setLastModifiedBy($this->session->userdata('first_name'))
            ->setCategory("Approve by ");
        // Add some data
        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"sumur");

        $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('O')->setWidth(20);

        $object->getActiveSheet()->mergeCells('A1:O1');
        $object->getActiveSheet()->mergeCells('A2:O2');
        $object->getActiveSheet()->mergeCells('A3:O3');
        $object->getActiveSheet()->mergeCells('A4:O4');
        $object->getActiveSheet()->mergeCells('A5:O5');

        $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

        $object->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('first_name'))
            ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
            ->setCellValue('A4', 'Terminal Peti Kemas')
            ->setCellValue('A5', 'Laporan Pencatatan Sumur Periode '.$tgl_awal.' s/d '.$tgl_akhir)
            ->setCellValue('A7', 'No')
            ->setCellValue('B7', 'ID Sumur')
            ->setCellValue('C7', 'Nama Sumur')
            ->setCellValue('D7', 'Nama Pompa')
            ->setCellValue('E7', 'Nama Flow Meter')
            ->setCellValue('F7', 'Start Running')
            ->setCellValue('G7', 'Cuaca')
            ->setCellValue('H7', 'Debit Air (L/Detik)')
            ->setCellValue('I7', 'Nilai Flow (m3)')
            ->setCellValue('J7', 'Finish Running')
            ->setCellValue('K7', 'Cuaca')
            ->setCellValue('L7', 'Debit Air (L/Detik)')
            ->setCellValue('M7', 'Nilai Flow (m3)')
            ->setCellValue('N7', 'Pemakaian (m3)')
            ->setCellValue('O7', 'Issued By')
        ;
        $no=0;
        //add data
        $counter=8;
        $ton_total = 0;
        $ex = $object->setActiveSheetIndex(0);

        foreach($result as $row){
            $no++;

            $object->getActiveSheet()->getStyle("A".$counter.":N".$counter)->applyFromArray($style);

            $ttl_awal = $row->flow_sumur_awal;
            $ttl_akhir = $row->flow_sumur_akhir;

            $ton_koma = $ttl_akhir - $ttl_awal;
            $ton_total += $ton_koma;
            $ton = $this->Koma($ton_koma);
            
            $ex->setCellValue("A".$counter,"$no");
            $ex->setCellValue("B".$counter,"$row->id_sumur");
            $ex->setCellValue("C".$counter,"$row->nama_sumur");
            $ex->setCellValue("D".$counter,"$row->nama_pompa");
            $ex->setCellValue("E".$counter,"$row->nama_flowmeter");
            $ex->setCellValue("F".$counter,"$row->waktu_rekam_awal");
            $ex->setCellValue("G".$counter,"$row->cuaca_awal");
            $ex->setCellValue("H".$counter,"$row->debit_air_awal");
            $ex->setCellValue("I".$counter,"$row->flow_sumur_awal");
            $ex->setCellValue("J".$counter,"$row->waktu_rekam_akhir");
            $ex->setCellValue("K".$counter,"$row->cuaca_akhir");
            $ex->setCellValue("L".$counter,"$row->debit_air_akhir");
            $ex->setCellValue("M".$counter,"$row->flow_sumur_akhir");
            $ex->setCellValue("N".$counter,"$ton");
            $ex->setCellValue("O".$counter,"$row->issued_by");

            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("K".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("L".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("M".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("N".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("O".$counter)->applyFromArray($style);
                
            $counter=$counter+1;
        }
        $object->getActiveSheet()->mergeCells('A'.$counter.':M'.$counter);
        $object->getActiveSheet()->getStyle("A".$counter.":O".$counter)->applyFromArray($style);

        $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
        $object->getActiveSheet()->getStyle("N".$counter)->applyFromArray($font);

        $ex->setCellValue("A".$counter,"Total");
        $ex->setCellValue("N".$counter,"$ton_total");

        // Rename sheet
        $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Sumur');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $object->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Transaksi_Sumur_periode_'.$tgl_awal.'_'.$tgl_akhir.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function excelTandon($tgl_awal,$tgl_akhir) {
        // Create new PHPExcel object
        $object = new PHPExcel();
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $font = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Times New Roman'
            )
        );

        $object->getActiveSheet()->getStyle("A7:F7")->applyFromArray($style);
        $object->getActiveSheet()->getStyle("A7:F7")->applyFromArray($font);
        $object->getActiveSheet()->getStyle("A1:F5")->applyFromArray($font);
        $object->getActiveSheet()->getStyle('A7:F7')->getAlignment()->setWrapText(true);

        // Set properties
        $object->getProperties()->setCreator($this->session->userdata('username'))
            ->setLastModifiedBy($this->session->userdata('username'))
            ->setCategory("Approve by ");
        // Add some data
        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"tandon");

        $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);

        $object->getActiveSheet()->mergeCells('A1:F1');
        $object->getActiveSheet()->mergeCells('A2:F2');
        $object->getActiveSheet()->mergeCells('A3:F3');
        $object->getActiveSheet()->mergeCells('A4:F4');
        $object->getActiveSheet()->mergeCells('A5:F5');

        $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

        $object->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('username'))
            ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
            ->setCellValue('A4', 'Terminal Peti Kemas')
            ->setCellValue('A5', 'Laporan Pencatatan Sumur Periode '.$tgl_awal.' s/d '.$tgl_akhir)
            ->setCellValue('A7', 'No')
            ->setCellValue('B7', 'Nama Tandon')
            ->setCellValue('C7', 'Lokasi')
            ->setCellValue('D7', 'Waktu Perekaman')
            ->setCellValue('E7', 'Issued By')
            ->setCellValue('F7', 'Total Pengisian (m3)')
        ;
        $no=0;
        //add data
        $counter=8;
        $ton_total = 0;
        $ex = $object->setActiveSheetIndex(0);

        foreach($result as $row){
            $no++;

            $object->getActiveSheet()->getStyle("A".$counter.":F".$counter)->applyFromArray($style);

            $ton_total += $row->total_pengisian;
            $ton = $this->Koma($row->total_pengisian);
            
            $ex->setCellValue("A".$counter,"$no");
            $ex->setCellValue("B".$counter,"$row->nama_tandon");
            $ex->setCellValue("C".$counter,"$row->lokasi");
            $ex->setCellValue("D".$counter,"$row->waktu_perekaman");
            $ex->setCellValue("E".$counter,"$row->issued_by");
            $ex->setCellValue("F".$counter,"$ton");

            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
                
            $counter=$counter+1;
        }
        $object->getActiveSheet()->mergeCells('A'.$counter.':E'.$counter);
        $object->getActiveSheet()->getStyle("A".$counter.":F".$counter)->applyFromArray($style);

        $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
        $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($font);

        $ex->setCellValue("A".$counter,"Total");
        $ex->setCellValue("F".$counter,"$ton_total");

        // Rename sheet
        $object->getActiveSheet()->setTitle('Lap_Transaksi_Air_Tandon');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $object->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Transaksi_Tandon_periode_'.$tgl_awal.'_'.$tgl_akhir.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function excelRealisasiAir($tgl_awal,$tgl_akhir) {
        // Create new PHPExcel object
        $object = new PHPExcel();
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $font = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Times New Roman'
            )
        );

        $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($style);
        $object->getActiveSheet()->getStyle("A7:J7")->applyFromArray($font);
        $object->getActiveSheet()->getStyle("A1:J5")->applyFromArray($font);
        $object->getActiveSheet()->getStyle('A7:J7')->getAlignment()->setWrapText(true);

        // Set properties
        $object->getProperties()->setCreator($this->session->userdata('username'))
            ->setLastModifiedBy($this->session->userdata('username'))
            ->setCategory("Approve by ");
        // Add some data
        $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,"realisasiAir");

        $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('J')->setWidth(20);

        $object->getActiveSheet()->mergeCells('A1:J1');
        $object->getActiveSheet()->mergeCells('A2:J2');
        $object->getActiveSheet()->mergeCells('A3:J3');
        $object->getActiveSheet()->mergeCells('A4:J4');
        $object->getActiveSheet()->mergeCells('A5:J5');

        $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

        $object->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('username'))
            ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
            ->setCellValue('A4', 'Terminal Peti Kemas')
            ->setCellValue('A5', 'Laporan Pencatatan Sumur Periode '.$tgl_awal.' s/d '.$tgl_akhir)
            ->setCellValue('A7', 'No')
            ->setCellValue('B7', 'Nama Tempat')
            ->setCellValue('C7', 'Nama Flow Meter')
            ->setCellValue('D7', 'lokasi')
            ->setCellValue('E7', 'Tanggal Awal Realisasi')
            ->setCellValue('F7', 'Tanggal Akhir Realisasi')
            ->setCellValue('G7', 'Flow Awal')
            ->setCellValue('H7', 'Flow Akhir')
            ->setCellValue('I7', 'Issued By')
            ->setCellValue('J7', 'Total Pengisian (m3)')
        ;
        $no=0;
        //add data
        $counter=8;
        $ton_total = 0;
        $ex = $object->setActiveSheetIndex(0);

        foreach($result as $row){
            $no++;

            $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);

            $ttl_awal = $row->flow_awal;
            $ttl_akhir = $row->flow_akhir;
            $ton =$ttl_akhir - $ttl_awal;
            $ton_total += $ton;
            
            $ex->setCellValue("A".$counter,"$no");
            $ex->setCellValue("B".$counter,"$row->nama_tenant");
            $ex->setCellValue("C".$counter,"$row->nama_flowmeter");
            $ex->setCellValue("D".$counter,"$row->lokasi");
            $ex->setCellValue("E".$counter,"$row->tgl_awal");
            $ex->setCellValue("F".$counter,"$row->tgl_akhir");
            $ex->setCellValue("G".$counter,"$ttl_awal");
            $ex->setCellValue("H".$counter,"$ttl_akhir");
            $ex->setCellValue("I".$counter,"$row->issued_by");
            $ex->setCellValue("J".$counter,"$ton");

            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("F".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("G".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("H".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("I".$counter)->applyFromArray($style);
            $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($style);
                
            $counter=$counter+1;
        }
        $object->getActiveSheet()->mergeCells('A'.$counter.':I'.$counter);
        $object->getActiveSheet()->getStyle("A".$counter.":J".$counter)->applyFromArray($style);

        $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
        $object->getActiveSheet()->getStyle("J".$counter)->applyFromArray($font);

        $ex->setCellValue("A".$counter,"Total");
        $ex->setCellValue("J".$counter,"$ton_total");

        // Rename sheet
        $object->getActiveSheet()->setTitle('Lap_Pemakaian_Air');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $object->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan_Pemakaian_Air_periode_'.$tgl_awal.'_'.$tgl_akhir.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function cetakLaporan($tgl_awal,$tgl_akhir,$tipe,$id=''){
        ini_set('memory_limit', '256M');
        $this->dompdf->set_option('enable_html5_parser', TRUE);
        if($tipe == "darat"){
            $data['title'] = 'Laporan Transaksi Air Darat Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
            $data['laporan'] = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang

            if($this->session->userdata('role_name') == "wtp")
                $this->load->view('report/cetaklaporan/v_cetaklaporan_darat_wtp', $data);
            elseif($this->session->userdata('role_name') == "operasi")
                $this->load->view('report/cetaklaporan/v_cetaklaporan_darat_operasi', $data);
            elseif($this->session->userdata('role_name') == "keuangan")
                $this->load->view('report/cetaklaporan/v_cetaklaporan_darat_keuangan', $data);
            else
                $this->load->view('report/cetaklaporan/v_cetaklaporan_darat', $data);

            $paper_size  = 'A4'; //paper size
            $orientation = 'landscape'; //tipe format kertas
            $html = $this->output->get_output();

            $this->dompdf->set_paper($paper_size, $orientation);
            //Convert to PDF
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
        }
        else if($tipe == "laut"){
            $data['title'] = 'Laporan Transaksi Air Kapal Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
            $data['laporan'] = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang

            $this->load->view('report/cetaklaporan/v_cetaklaporan_kapal', $data);

            $paper_size  = 'A4'; //paper size
            $orientation = 'landscape'; //tipe format kertas
            $html = $this->output->get_output();

            $this->dompdf->set_paper($paper_size, $orientation);
            //Convert to PDF
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
        }
        else if($tipe == "laut_operasi"){
            $data['title'] = 'Laporan Transaksi Air Kapal Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
            $data['laporan'] = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang

            if($this->session->userdata('role_name') == "operasi")
                $this->load->view('report/cetaklaporan/v_cetaklaporan_kapal_admin_operasi', $data);
            else
                $this->load->view('report/cetaklaporan/v_cetaklaporan_kapal_operasi', $data);
            
            $paper_size  = 'A4'; //paper size
            $orientation = 'landscape'; //tipe format kertas
            $html = $this->output->get_output();

            $this->dompdf->set_paper($paper_size, $orientation);
            //Convert to PDF
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
        }
        else if($tipe == "flow"){
            $data['title'] = 'Laporan Pencatatan Flow Meter Per Tanggal '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
            $data['laporan'] = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang
            $data['tgl_awal'] = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
            $this->load->view('report/cetaklaporan/v_cetaklaporan_flow', $data);

            $paper_size  = 'A4'; //paper size
            $orientation = 'landscape'; //tipe format kertas
            $html = $this->output->get_output();

            $this->dompdf->set_paper($paper_size, $orientation);
            //Convert to PDF
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
        }
        else if($tipe == "per_flow"){
            $result = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,$tipe,$id); //query model semua barang
            $judul = $this->tenant->getDataFlowmeter($tgl_awal,$tgl_akhir,$id)->nama_flowmeter;
            $id_flow = $this->tenant->getDataFlowmeter($tgl_awal,$tgl_akhir,$id)->id_flowmeter;
            $data['laporan'] = $result;
            $data['sub_title'] = $judul;
            $data['id_flowmeter'] = $id_flow;
            $data['title'] = 'Pencatatan Harian Flowmeter Periode '.date('d-M-Y', strtotime($tgl_awal)).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
            $data['tgl_awal'] = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
            $this->load->view('report/cetaklaporan/v_cetaklaporan_per_flow', $data);

            $paper_size  = 'A4'; //paper size
            $orientation = 'landscape'; //tipe format kertas
            $html = $this->output->get_output();

            $this->dompdf->set_paper($paper_size, $orientation);
            //Convert to PDF
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
        }
        else if($tipe == "sumur"){
            $data['title'] = 'Laporan Pencatatan Sumur Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
            $data['laporan'] = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang
            $data['tgl_awal'] = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
            $this->load->view('report/cetaklaporan/v_cetaklaporan_sumur', $data);

            $paper_size  = 'A4'; //paper size
            $orientation = 'landscape'; //tipe format kertas
            $html = $this->output->get_output();

            $this->dompdf->set_paper($paper_size, $orientation);
            //Convert to PDF
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
        }
        else if($tipe == "tandon"){
            $data['title'] = 'Laporan Pengisian Tandon Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
            $data['laporan'] = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang
            $data['tgl_awal'] = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
            $this->load->view('report/cetaklaporan/v_cetaklaporan_tandon', $data);

            $paper_size  = 'A4'; //paper size
            $orientation = 'landscape'; //tipe format kertas
            $html = $this->output->get_output();

            $this->dompdf->set_paper($paper_size, $orientation);
            //Convert to PDF
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
        }
        else if($tipe == "ruko_keuangan"){
            $data['title'] = 'Laporan Transaksi Air Ruko Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
            $data['laporan'] = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang
            $data['tgl_awal'] = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
            $this->load->view('report/cetaklaporan/v_cetaklaporan_ruko_keuangan', $data);

            $paper_size  = 'A4'; //paper size
            $orientation = 'landscape'; //tipe format kertas
            $html = $this->output->get_output();

            $this->dompdf->set_paper($paper_size, $orientation);
            //Convert to PDF
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
        }
        else if($tipe == "realisasiAir"){
            $data['title'] = 'Laporan Pemakaian Air Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
            $data['laporan'] = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang
            $data['tgl_awal'] = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
            $this->load->view('report/cetaklaporan/v_cetaklaporan_pemakaian_air', $data);

            $paper_size  = 'A4'; //paper size
            $orientation = 'landscape'; //tipe format kertas
            $html = $this->output->get_output();

            $this->dompdf->set_paper($paper_size, $orientation);
            //Convert to PDF
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
        }
        else{
            $data['title'] = 'Laporan Transaksi Air Ruko Periode '.date('d-M-Y', strtotime($tgl_awal )).' s/d '.date('d-M-Y', strtotime($tgl_akhir )); //judul title
            $data['laporan'] = $this->report->getDataLaporan($tgl_awal,$tgl_akhir,$tipe); //query model semua barang
            $data['tgl_awal'] = $tgl_awal;
            $data['tgl_akhir'] = $tgl_akhir;
            $this->load->view('report/cetaklaporan/v_cetaklaporan_ruko_operasi', $data);

            $paper_size  = 'A4'; //paper size
            $orientation = 'landscape'; //tipe format kertas
            $html = $this->output->get_output();

            $this->dompdf->set_paper($paper_size, $orientation);
            //Convert to PDF
            $this->dompdf->load_html($html);
            $this->dompdf->render();
            $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
        }
    }

    public function laporanProduksi(){
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $air_kapal = $this->report->getLaporanProduksiAirKapal($tgl_awal,$tgl_akhir);
        $air_darat = $this->report->getLaporanProduksiAirDarat($tgl_awal,$tgl_akhir);
        $air_tenant = $this->report->getLaporanProduksiAirTenant($tgl_awal,$tgl_akhir);
        $total_realisasi_kapal = 0;
        $total_bayar_kapal = 0;
        $total_permintaan_darat = 0;
        $total_bayar_darat = 0;
        $total_pemakaian_tenant = 0;
        $total_bayar_tenant = 0;

        $tabel = '<center><h4>Laporan Produksi Air Periode '.date('d-m-Y', strtotime($tgl_awal)).' s/d '.date('d-m-Y', strtotime($tgl_akhir )).'</h4></center>';
        
        if($air_kapal != NULL || $air_darat != NULL || $air_tenant != NULL){
            if($air_kapal != NULL){
                $no = 1;
                $tabel .= '
                        <table class="table table-responsive table-condensed table-striped">
                        <thead>
                            <tr><th colspan="5">Produksi Air Kapal</th></tr>
                            <tr>
                                <th align="center"><center>No</th>
                                <th align="center"><center>Nama Agent</th>
                                <th align="center"><center>Nama Vessel</th>
                                <th align="center"><center>Total Realisasi (m3)</th>
                                <th align="center"><center>Jumlah Bayar (Rp.)</th>
                            </tr>
                        </thead>
                        <tbody>';
    
                foreach($air_kapal as $row){
                    $tabel .='
                        <tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->nama_agent.'</td>
                            <td align="center">'.$row->nama_vessel.'</td>
                            <td align="center">'.$this->koma($row->total_realisasi).'</td>
                            <td align="center">'.$this->rupiah($row->jumlah_bayar).'</td>
                        </tr>
                        ';
                    $total_realisasi_kapal += $row->total_realisasi;
                    $total_bayar_kapal += $row->jumlah_bayar;
                    $no++;
                }
    
                $tabel .= '
                        <tr>
                            <td align="center" colspan="3"><b>Total</b></td>
                            <td align="center"><b>'.$this->Koma($total_realisasi_kapal).'</b></td>
                            <td align="center"><b>'.$this->rupiah($total_bayar_kapal).'</b></td>
                        </tr>
                    </tbody>';
            }
    
            if($air_darat != NULL){
                $tabel .='    
                    <thead>
                        <tr><th colspan="5">Produksi Air Darat</th></tr>
                        <tr>
                            <th align="center"><center>No</th>
                            <th colspan="2" align="center"><center>Nama Pengguna Jasa</th>
                            <th align="center"><center>Total Permintaan (m3)</th>
                            <th align="center"><center>Jumlah Bayar (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                foreach($air_darat as $row){
                    $tabel .='
                        <tr>
                            <td align="center">'.$no.'</td>
                            <td colspan="2" align="center">'.$row->nama_pengguna_jasa.'</td>
                            <td align="center">'.$this->koma($row->total_permintaan).'</td>
                            <td align="center">'.$this->rupiah($row->jumlah_bayar).'</td>
                        </tr>
                        ';
                    $total_permintaan_darat += $row->total_permintaan;
                    $total_bayar_darat += $row->jumlah_bayar;
                    $no++;
                }    
    
                $tabel .= '
                    <tr>
                        <td align="center" colspan="3"><b>Total</b></td>
                        <td align="center"><b>'.$this->Koma($total_permintaan_darat).'</b></td>
                        <td align="center"><b>'.$this->rupiah($total_bayar_darat).'</b></td>
                    </tr>
                </tbody>';
            }
            if($air_tenant != NULL){
                $tabel .='    
                    <thead>
                        <tr><th colspan="5">Pemakaian Air Tenant</th></tr>
                        <tr>
                            <th align="center"><center>No</th>
                            <th align="center"><center>Nama Tenant</th>
                            <th align="center"><center>Nama ID Flowmeter</th>
                            <th align="center"><center>Total Pemakaian (m3)</th>
                            <th align="center"><center>Jumlah Bayar (Rp.)</th>
                        </tr>
                    </thead>
                    <tbody>';
                
                foreach($air_tenant as $row){
                    $tabel .='
                        <tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row->nama_tenant.'</td>
                            <td align="center">'.$row->id_flowmeter.'</td>
                            <td align="center">'.$this->Koma($row->total_pakai).'</td>
                            <td align="center">'.$this->rupiah($row->total_bayar).'</td>
                        </tr>
                        ';
                    $total_pemakaian_tenant += $row->total_pakai;
                    $total_bayar_tenant += $row->total_bayar;
                    $no++;
                }    
    
                $tabel .= '
                    <tr>
                        <td align="center" colspan="3"><b>Total</b></td>
                        <td align="center"><b>'.$this->Koma($total_pemakaian_tenant).'</b></td>
                        <td align="center"><b>'.$this->rupiah($total_bayar_tenant).'</b></td>
                    </tr>
                </tbody>';
            }
            
            $total_bayar_keseluruhan = $total_bayar_kapal + $total_bayar_darat + $total_bayar_tenant;
            $total_produksi_air = $total_pemakaian_tenant + $total_permintaan_darat + $total_realisasi_kapal;

            $tabel .='
                <tfoot>
                    <tr>
                        <td align="center" colspan="3"><b>Total Keseluruhan</b></td>
                        <td align="center"><b>'.$this->Koma($total_produksi_air).'</b></td>
                        <td align="center"><b>'.$this->rupiah($total_bayar_keseluruhan).'</b></td>
                    </tr>
                </tfoot>    
                </table>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/cetakLaporanProduksi/".$tgl_awal."/".$tgl_akhir).'>Cetak PDF</a>
                <a class="btn btn-primary" target="_blank" href='.base_url("report/excelProduksiAir/".$tgl_awal."/".$tgl_akhir).'>Cetak Excel</a>';

            $data = array(
                'status' => 'success',
                'tabel' => $tabel
            );
        }
        else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function excelProduksiAir($tgl_awal,$tgl_akhir){
        // Create new PHPExcel object
        $object = new PHPExcel();
        $style = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $font = array(
            'font'  => array(
                'bold'  => true,
                'size'  => 12,
                'name'  => 'Times New Roman'
            )
        );

        $object->getActiveSheet()->getStyle("A7:E7")->applyFromArray($style);
        $object->getActiveSheet()->getStyle("A7:E7")->applyFromArray($font);
        $object->getActiveSheet()->getStyle("A1:E5")->applyFromArray($font);
        $object->getActiveSheet()->getStyle('A7:E7')->getAlignment()->setWrapText(true);

        // Set properties
        $object->getProperties()->setCreator($this->session->userdata('username'))
            ->setLastModifiedBy($this->session->userdata('username'))
            ->setCategory("Approve by ");
        // Add some data
        $air_kapal = $this->report->getLaporanProduksiAirKapal($tgl_awal,$tgl_akhir);
        $air_darat = $this->report->getLaporanProduksiAirDarat($tgl_awal,$tgl_akhir);
        $air_tenant = $this->report->getLaporanProduksiAirTenant($tgl_awal,$tgl_akhir);

        $total_realisasi_kapal = 0;
        $total_bayar_kapal = 0;
        $total_permintaan_darat = 0;
        $total_bayar_darat = 0;
        $total_pemakaian_tenant = 0;
        $total_bayar_tenant = 0;

        $object->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $object->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $object->getActiveSheet()->getColumnDimension('E')->setWidth(20);

        $object->getActiveSheet()->mergeCells('A1:E1');
        $object->getActiveSheet()->mergeCells('A2:E2');
        $object->getActiveSheet()->mergeCells('A3:E3');
        $object->getActiveSheet()->mergeCells('A4:E4');
        $object->getActiveSheet()->mergeCells('A5:E5');

        $tgl_awal = date('d-m-Y',strtotime($tgl_awal));
        $tgl_akhir = date('d-m-Y',strtotime($tgl_akhir));

        $object->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Generated by : '.$this->session->userdata('username'))
            ->setCellValue('A3', 'PT Kaltim Kariangau Terminal')
            ->setCellValue('A4', 'Terminal Peti Kemas')
            ->setCellValue('A5', 'Laporan Produksi Air Periode '.$tgl_awal.' s/d '.$tgl_akhir)
        ;
        $no=0;
        //add data
        $counter=8;
        $ex = $object->setActiveSheetIndex(0);

        if($air_kapal != NULL){
            $object->setActiveSheetIndex(0)
                ->setCellValue('A7', 'No')
                ->setCellValue('B7', 'Nama Agent')
                ->setCellValue('C7', 'Nama Vessel')
                ->setCellValue('D7', 'Total Realisasi (m3)')
                ->setCellValue('E7', 'Jumlah Bayar (Rp.)')
            ;
            foreach($air_kapal as $row){
                $no++;
                $object->getActiveSheet()->getStyle("A".$counter.":E".$counter)->applyFromArray($style);
    
                $total_realisasi_kapal += $row->total_realisasi;
                $total_bayar_kapal += $row->jumlah_bayar;
                
                $ex->setCellValue("A".$counter,"$no");
                $ex->setCellValue("B".$counter,"$row->nama_agent");
                $ex->setCellValue("C".$counter,"$row->nama_vessel");
                $ex->setCellValue("D".$counter,"$row->total_realisasi");
                $ex->setCellValue("E".$counter,"$row->jumlah_bayar");
    
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                    
                $counter=$counter+1;
            }

            $object->getActiveSheet()->mergeCells('A'.$counter.':C'.$counter);
            $object->getActiveSheet()->getStyle("A".$counter.":E".$counter)->applyFromArray($style);
    
            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($font);
    
            $ex->setCellValue("A".$counter,"Total");
            $ex->setCellValue("D".$counter,"$total_realisasi_kapal");
            $ex->setCellValue("E".$counter,"$total_bayar_kapal");
        }

        if($air_darat != NULL){
            $counter++;
            $object->getActiveSheet()->mergeCells('B'.$counter.':C'.$counter);
            $object->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, 'No')
                ->setCellValue('B'.$counter, 'Nama Pengguna Jasa')
                ->setCellValue('D'.$counter, 'Total Permintaan (m3)')
                ->setCellValue('E'.$counter, 'Jumlah Bayar (Rp.)')
            ;

            foreach($air_darat as $row){
                $no++;
                $object->getActiveSheet()->getStyle("A".$counter.":E".$counter)->applyFromArray($style);
    
                $total_permintaan_darat += $row->total_permintaan;
                $total_bayar_darat += $row->jumlah_bayar;
                $object->getActiveSheet()->mergeCells('B'.$counter.':C'.$counter);
                $ex->setCellValue("A".$counter,"$no");
                $ex->setCellValue("B".$counter,"$row->nama_pengguna_jasa");
                $ex->setCellValue("D".$counter,"$row->total_permintaan");
                $ex->setCellValue("E".$counter,"$row->jumlah_bayar");
    
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                    
                $counter=$counter+1;
            }

            $object->getActiveSheet()->mergeCells('A'.$counter.':C'.$counter);
            $object->getActiveSheet()->getStyle("A".$counter.":E".$counter)->applyFromArray($style);

            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($font);

            $ex->setCellValue("A".$counter,"Total");
            $ex->setCellValue("D".$counter,"$total_permintaan_darat");
            $ex->setCellValue("E".$counter,"$total_bayar_darat");
        }

        if($air_tenant != NULL){
            $counter++;
            $object->getActiveSheet()->mergeCells('B'.$counter.':C'.$counter);
            $object->setActiveSheetIndex(0)
                ->setCellValue('A'.$counter, 'No')
                ->setCellValue('B'.$counter, 'Nama Tenant')
                ->setCellValue('C'.$counter, 'ID Flowmeter')
                ->setCellValue('D'.$counter, 'Total Pemakaian (m3)')
                ->setCellValue('E'.$counter, 'Jumlah Bayar (Rp.)')
            ;

            foreach($air_tenant as $row){
                $no++;
                $object->getActiveSheet()->getStyle("A".$counter.":E".$counter)->applyFromArray($style);
    
                $total_pemakaian_tenant += $row->total_pakai;
                $total_bayar_tenant += $row->total_bayar;
                
                $ex->setCellValue("A".$counter,"$no");
                $ex->setCellValue("B".$counter,"$row->nama_tenant");
                $ex->setCellValue("C".$counter,"$row->id_flowmeter");
                $ex->setCellValue("D".$counter,"$row->total_pakai");
                $ex->setCellValue("E".$counter,"$row->total_bayar");
    
                $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("B".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("C".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($style);
                $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($style);
                    
                $counter=$counter+1;
            }

            $object->getActiveSheet()->mergeCells('A'.$counter.':C'.$counter);
            $object->getActiveSheet()->getStyle("A".$counter.":E".$counter)->applyFromArray($style);

            $object->getActiveSheet()->getStyle("A".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("D".$counter)->applyFromArray($font);
            $object->getActiveSheet()->getStyle("E".$counter)->applyFromArray($font);

            $ex->setCellValue("A".$counter,"Total");
            $ex->setCellValue("D".$counter,"$total_pemakaian_tenant");
            $ex->setCellValue("E".$counter,"$total_bayar_tenant");
        }

        // Rename sheet
        $object->getActiveSheet()->setTitle('Lap_Produksi_Air');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $object->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="laporan_produksi_air_periode_'.$tgl_awal.'_'.$tgl_akhir.'.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function cetakLaporanProduksi($tgl_awal,$tgl_akhir){
        ini_set('memory_limit', '256M');
        $data['air_kapal'] = $this->report->getLaporanProduksiAirKapal($tgl_awal,$tgl_akhir);
        $data['air_darat'] = $this->report->getLaporanProduksiAirDarat($tgl_awal,$tgl_akhir);
        $data['air_tenant'] = $this->report->getLaporanProduksiAirTenant($tgl_awal,$tgl_akhir);
        $data['title'] = 'Laporan Produksi Air Periode '
                        .date('d-M-Y', strtotime($tgl_awal )).' s/d '
                        .date('d-M-Y', strtotime($tgl_akhir )); //judul title

        $this->load->view('report/cetaklaporan/v_cetaklaporan_produksi', $data);
        
        $paper_size  = 'A4'; //paper size
        $orientation = 'potrait'; //tipe format kertas
        
        $html = $this->output->get_output(array("compress" => 0));
        $this->dompdf->set_option('enable_html5_parser', TRUE);
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("laporan.pdf", array('Attachment'=>0));
    }

}

?>