<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kapal extends MY_Controller{

    //fungsi untuk transaksi laut
    public function get_pembeli_laut() {
        $nama = $this->input->post('nama_lct',TRUE); //variabel kunci yang di bawa dari input text id kode
        $tipe = "laut";
        $query = $this->data->get_pembeli($tipe,$nama); //query model

        if($query == TRUE){
            $pelanggan = array();
            foreach ($query as $data) {
                $pelanggan[]     = array(
                    'label' => $data->nama_vessel, //variabel array yg dibawa ke label ketikan kunci
                    'id' => $data->id_pengguna_jasa,
                    'id_kapal' => $data->id_vessel,
                    'nama_lct' => $data->nama_vessel , //variabel yg dibawa ke id nama
                    'pengguna' => $data->pengguna_jasa_id_tarif,
                    'nama_perusahaan' => $data->nama_agent,
                    'alamat' => $data->alamat,
                    'no_telp' => $data->no_telp
                );
            }
        }

        echo json_encode($pelanggan);      //data array yang telah kota deklarasikan dibawa menggunakan json
    }

    public function get_agent() {
        $nama = $this->input->post('nama_perusahaan',TRUE); //variabel kunci yang di bawa dari input text id kode
        $tipe = "agent";
        $query = $this->data->get_pembeli($tipe,$nama); //query model

        if($query == TRUE){
            $pelanggan = array();
            foreach ($query as $data) {
                $pelanggan[]     = array(
                    'label' => $data->nama_agent, //variabel array yg dibawa ke label ketikan kunci
                    'id_agent' => $data->id_agent,
                    'nama_perusahaan' => $data->nama_agent,
                    'alamat' => $data->alamat, //variabel yang dibawa ke id alamat
                    'no_telp' => $data->no_telp, //variabel yang dibawa ke id no telp
                );
            }
        }

        echo json_encode($pelanggan);      //data array yang telah kota deklarasikan dibawa menggunakan json
    }

    public function transaksi_laut() {
        $id_pengguna = $this->input->post('id_pengguna');
        $voy_no = $this->input->post('voy_no');
        $nama_pemohon = $this->input->post('nama_pemohon');
        $tanggal = $this->input->post('tanggal');
        $tonnase = $this->input->post('tonnase');
        $tipe_kapal = $this->input->post('tipe_kapal');

        $data_pengguna = $this->data->getDataPembeliLaut($id_pengguna);
        $data_tarif = $this->data->getDataTarif($data_pengguna->pengguna_jasa_id_tarif);
        $result = FALSE;

        $this->form_validation->set_rules('nama_lct', 'Nama VESSEL', 'required');
        $this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('tonnase', 'Total Pengisian', 'required');

        $data_transaksi = array(
            'pembeli_laut_id_pengguna_jasa' => $id_pengguna,
            'voy_no' => $voy_no,
            'nama_pemohon' => $nama_pemohon,
            'tgl_transaksi' => date("Y-m-d H:i:s",time()),
            'waktu_pelayanan' => $tanggal,
            'tipe_kapal' => $tipe_kapal,
            'total_permintaan' => $tonnase,
            'tarif' => $data_tarif->tarif,
            'diskon' => $data_tarif->diskon,
            'issued_at' => date("Y-m-d H:i:s",time()),
            'issued_by' => $this->session->userdata('nama')
        );

        if ($this->form_validation->run() == FALSE) {
            $data['title']='Aplikasi Pelayanan Jasa Air Bersih';
            $data['pengguna'] = $this->data->get_pengguna("laut","laut");
            $this->load->template('v_input_laut',$data);
        }
        else {
            $result = $this->data->input_transaksi("laut",$data_transaksi);
        }

        if($result == TRUE){
            $web = base_url('main');
            echo "<script type='text/javascript'>
                    alert('Permintaan Berhasil Di Input')
                    window.location.replace('$web')
                    </script>";
        }else{
            $web = base_url('main/view?id=laut');
            echo "<script type='text/javascript'>
                    alert('Permintaan Gagal Di Input ! Coba Lagi')
                    window.location.replace('$web')
                    </script>";
        }
    }

    //untuk membuat tampilan tabel status pembayaran transaksi kapal,darat dan ruko
    public function tabel_pembayaran(){
        $tipe = $this->input->get('id');

        $result = $this->data->get_tabel_transaksi($tipe);
        $data = array();
        $baris = array();
        $no = 1;
        $warna = "";

        if($result != NULL){
            foreach ($result as $row){
                $aksi = "";
                $flow_sebelum = "";
                $flow_sesudah = "";

                $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                if($row->voy_no == NULL){
                    $row->voy_no = "";
                }

                if(($this->session->userdata('role') == "operasi" || $this->session->userdata('role') == "admin") && $tipe == "laut_operasi") {
                    if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL){
                        $aksi = '<a class="btn btn-primary glyphicon glyphicon-list-alt" target="_blank" href="'.base_url("main/cetakPerhitungan?id=".$row->id_transaksi."").'" title="Cetak Perhitungan" onclick="reload()"></a>';
                    }
                    else{
                        $aksi = '';
                    }

                    if($row->status_print == 1){
                        $warna = "#7FFF00";
                    }
                    else{
                        $warna = "";
                    }
                }
                else if($this->session->userdata('role') == "keuangan") {
                    if ($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL) {
                        $aksi = '<a class="btn btn-sm btn-primary glyphicon glyphicon-list-alt" href="javascript:void(0)" title="Realisasi Piutang" onclick="realisasi(' . "'" . $row->id_transaksi . "'" . ')"></a>';
                    } else {
                        $aksi = '';
                    }
                }
                else if($this->session->userdata('role') == "wtp" || ($this->session->userdata('role') == "admin" && $tipe == "laut")){
                    if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL) {
                        $aksi = '<a class="btn btn-primary glyphicon glyphicon-list-alt" target="_blank" href="' . base_url("main/cetakPengisian?id=" . $row->id_transaksi . "") . '" title="Cetak Form Pengisian"></a>&nbsp;';
                    }
                    else{
                        $aksi = '';
                    }
                }
                else if($this->session->userdata('role') == "admin" && $tipe == "laut_keuangan_admin"){
                    if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL){
                        $aksi = '&nbsp;<a class="btn btn-sm btn-primary glyphicon glyphicon-list-alt" href="javascript:void(0)" title="Realisasi Piutang" onclick="realisasi(' . "'" . $row->id_transaksi . "'" . ')"></a>';
                    } else{
                        $aksi = '';
                    }
                }
                else if($this->session->userdata('role') == "perencanaan" || ($this->session->userdata('role') == "admin" && $tipe == "laut_perencanaan")){
                    if($row->flowmeter_awal == NULL && $row->flowmeter_akhir == NULL)
                        $aksi = '<a class="btn btn-sm btn-danger glyphicon glyphicon-trash" href="javascript:void(0)" title="Batal Transaksi" onclick="batal(' . "'" . $row->id_transaksi . "'" . ')"></a>';
                    else
                        $aksi = "";
                }

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
                    $total = ($row->tarif * $realisasi) - (($row->diskon / 100) * ($row->tarif * $realisasi));
                    $tarif = $row->tarif - ($row->tarif * ($row->diskon / 100));
                }
                else{
                    $tarif = $row->tarif;
                    $total = $row->tarif * $realisasi;
                }

                if($total >= 250000 && $total <= 1000000){
                    $materai = 3000;
                    $total_bayar = $total + $materai;
                    $total_bayar = $this->Ribuan($total_bayar);
                }
                else if($total > 1000000){
                    $materai = 6000;
                    $total_bayar = $total + $materai;
                    $total_bayar = $this->Ribuan($total_bayar);
                }
                else {
                    $materai = 0;
                    $total_bayar = $total + $materai;
                    $total_bayar = $this->Ribuan($total_bayar);
                }

                if($row->status_invoice == 1){
                    if($this->session->userdata('role') == "keuangan"){
                        if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL) {
                            $data[] = array(
                                'no' => $no,
                                'id_kapal' => $row->id_vessel,
                                'nama_lct' => $row->nama_vessel,
                                'voy_no' => $row->voy_no,
                                'nama_perusahaan' => $row->nama_agent,
                                'nama_pemohon' => $row->nama_pemohon,
                                'tgl_transaksi' => $format_tgl,
                                'total_permintaan' => $row->total_permintaan . " Ton",
                                'flow_sebelum' => $flow_sebelum,
                                'flow_sesudah' => $flow_sesudah,
                                'realisasi' => $realisasi." Ton",
                                'tarif' => $this->Ribuan($tarif),
                                'pembayaran' => $total_bayar,
                                'aksi' => $aksi,
                            );
                            $aksi = "";
                            $no++;
                        }
                    }
                    else{
                        $data[] = array(
                            'no' => $no,
                            'id_kapal' => $row->id_vessel,
                            'nama_lct' => $row->nama_vessel,
                            'voy_no' => $row->voy_no,
                            'nama_perusahaan' => $row->nama_agent,
                            'nama_pemohon' => $row->nama_pemohon,
                            'tgl_transaksi' => $format_tgl,
                            'waktu_pelayanan' => $row->waktu_pelayanan,
                            'total_permintaan' => $row->total_permintaan . " Ton",
                            'flow_sebelum' => $flow_sebelum,
                            'flow_sesudah' => $flow_sesudah,
                            'tarif' => $this->Ribuan($tarif),
                            'pembayaran' => $total_bayar,
                            'realisasi' => $realisasi." Ton",
                            'aksi' => $aksi,
                            'warna' => $warna,
                        );
                        $aksi = "";
                        $no++;
                    }
                }
            }
        }
        
        echo json_encode($data);
    }

    //tampilan monitoring
    public function tabel_monitoring(){
        $tipe = $this->input->get('id');

        $result = $this->data->get_tabel_transaksi($tipe);
        $data = array();
        $no = 1;

        foreach ($result as $row){
            $aksi = "";
            $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));
            $realisasi = $row->flowmeter_akhir - $row->flowmeter_awal;

            if($this->session->userdata('role') == "operasi") {
                if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL){
                    $aksi = '<a class="btn btn-primary" target="_blank" href="'.base_url("main/cetakPerhitungan?id=".$row->id_transaksi."").'">Cetak Perhitungan</a><br><br>';
                }
            }else if($this->session->userdata('role') == "keuangan") {
                if ($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL) {
                    $aksi = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Realisasi" onclick="realisasi(' . "'" . $row->id_transaksi . "'" . ')"> Realisasi <br/> Piutang</a>';
                }
            }else{
                if($row->flowmeter_awal == NULL && $row->flowmeter_akhir == NULL)
                    $aksi = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Batal" onclick="batal(' . "'" . $row->id_transaksi . "'" . ')"> Batal <br/> Transaksi</a>';
                else
                    $aksi = "";
            }
            if($row->diskon != NULL){
                $tarif = $row->tarif - ($row->tarif * $row->diskon);
            }
            else{
                $tarif = $row->tarif;
            }

            if($row->flowmeter_awal == NULL){
                $flowmeter_awal = "0";
            }else{
                $flowmeter_awal = $row->flowmeter_awal;
            }

            if($row->flowmeter_akhir == NULL){
                $flowmeter_akhir = "0";
            }else{
                $flowmeter_akhir = $row->flowmeter_akhir;
            }

            if($row->realisasi_transaksi_laut_id_realisasi == NULL){
                if($this->session->userdata('role') == "keuangan"){
                    if($row->flowmeter_awal != NULL && $row->flowmeter_akhir != NULL) {
                        $data[] = array(
                            'no' => $no,
                            'id_kapal' => $row->id_vessel,
                            'nama_lct' => $row->nama_vessel,
                            'voy_no' => $row->voy_no,
                            'nama_perusahaan' => $row->nama_agent,
                            'nama_pemohon' => $row->nama_pemohon,
                            'tgl_transaksi' => $format_tgl,
                            'total_permintaan' => $row->total_permintaan . " Ton",
                            'flow_sebelum' => $flowmeter_awal,
                            'flow_sesudah' => $flowmeter_akhir,
                            'realisasi' => $realisasi." Ton",
                            'tarif' => $this->Ribuan($tarif),
                            'pembayaran' => $this->Ribuan($tarif * ($flowmeter_akhir - $flowmeter_awal)),
                            'aksi' => $aksi
                        );
                        $aksi = "";
                        $no++;
                    }
                }
                else{
                    $data[] = array(
                        'no' => $no,
                        'id_kapal' => $row->id_vessel,
                        'nama_lct' => $row->nama_vessel,
                        'voy_no' => $row->voy_no,
                        'nama_perusahaan' => $row->nama_agent,
                        'nama_pemohon' => $row->nama_pemohon,
                        'tgl_transaksi' => $format_tgl,
                        'total_permintaan' => $row->total_permintaan . " Ton",
                        'flow_sebelum' => $flowmeter_awal,
                        'flow_sesudah' => $flowmeter_akhir,
                        'realisasi' => $realisasi." Ton",
                        'aksi' => $aksi
                    );
                    $aksi = "";
                    $no++;
                }
            }
        }

        echo json_encode($data);
    }

    public function cancelTransaksiLaut(){
        $data['tipe'] = "laut";
        $data['id'] = $this->input->post('id');
        $cancel_data = $this->data->cekPengisian($data['id']);

        if($cancel_data == TRUE ){
            $this->data->cancelOrder($data);
            $data = array(
                'status' => 'sukses'
            );
        }
        else{
            $data = array(
                'status' => 'gagal'
            );
        }

        echo json_encode($data);
    }

    public function realisasi_pembayaran_laut(){
        $this->_validate_pembayaran_laut();
        $data = array(
            'id_ref_transaksi' => $this->input->post('id-transaksi'),
            'no_nota' => $this->input->post('no_nota'),
            'no_faktur' => $this->input->post('no_faktur'),
            'tgl_pembayaran' => date('Y-m-d H:i:s', time()),
            'issued_at' => date("Y-m-d H:i:s",time()),
            'issued_by' => $this->session->userdata('username')
        );
        $this->data->update_pembayaran($this->input->post('id-transaksi'), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function realisasi_pengantaran_laut($id) {
        $data = $this->data->get_by_id("laut_realisasi", $id);
        echo json_encode($data);
    }

    public function update_realisasi_laut(){
        $this->_validate_realisasi_laut();

        $data = array(
            'flowmeter_awal' => $this->input->post('flowmeter_awal'),
            'flowmeter_akhir' => $this->input->post('flowmeter_akhir'),
            'flowmeter_awal_2' => $this->input->post('flowmeter_awal_2'),
            'flowmeter_akhir_2' => $this->input->post('flowmeter_akhir_2'),
            'flowmeter_awal_3' => $this->input->post('flowmeter_awal_3'),
            'flowmeter_akhir_3' => $this->input->post('flowmeter_akhir_3'),
            'flowmeter_awal_4' => $this->input->post('flowmeter_awal_4'),
            'flowmeter_akhir_4' => $this->input->post('flowmeter_akhir_4'),
            'pengisi' => $this->input->post('pengisi'),
            'last_modified' => date("Y-m-d H:i:s",time()),
            'modified_by' => $this->session->userdata('username')
        );
        $this->data->update_realisasi('laut' ,array('id_transaksi' => $this->input->post('id-transaksi')), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate_realisasi_laut() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('flowmeter_awal') == NULL)
        {
            $data['inputerror'][] = 'flowmeter_awal';
            $data['error_string'][] = 'Kolom Flow Meter Awal Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('flowmeter_akhir') == NULL)
        {
            $data['inputerror'][] = 'flowmeter_akhir';
            $data['error_string'][] = 'Kolom Flow Meter Akhir Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('flowmeter_awal_2') == NULL && $this->input->post('flowmeter_akhir_2') != NULL)
        {
            $data['inputerror'][] = 'flowmeter_awal_2';
            $data['error_string'][] = 'Kolom Flow Meter Awal 2 Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('flowmeter_akhir_2') == NULL && $this->input->post('flowmeter_awal_2') != NULL)
        {
            $data['inputerror'][] = 'flowmeter_akhir_2';
            $data['error_string'][] = 'Kolom Flow Meter Akhir 2 Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('flowmeter_awal_3') == NULL && $this->input->post('flowmeter_akhir_3') != NULL)
        {
            $data['inputerror'][] = 'flowmeter_awal_3';
            $data['error_string'][] = 'Kolom Flow Meter Awal 3 Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('flowmeter_akhir_3') == NULL && $this->input->post('flowmeter_awal_3') != NULL)
        {
            $data['inputerror'][] = 'flowmeter_akhir_3';
            $data['error_string'][] = 'Kolom Flow Meter Akhir 3 Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('flowmeter_awal_4') == NULL && $this->input->post('flowmeter_akhir_4') != NULL)
        {
            $data['inputerror'][] = 'flowmeter_awal_4';
            $data['error_string'][] = 'Kolom Flow Meter Awal 4 Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('flowmeter_akhir_4') == NULL && $this->input->post('flowmeter_awal_4') != NULL)
        {
            $data['inputerror'][] = 'flowmeter_akhir_4';
            $data['error_string'][] = 'Kolom Flow Meter Akhir 4 Masih Kosong';
            $data['status'] = FALSE;
        }

        if(($this->input->post('flowmeter_awal_2') != NULL && $this->input->post('flowmeter_akhir_2') != NULL) && ($this->input->post('flowmeter_awal_2') > $this->input->post('flowmeter_akhir_2')))
        {
            $data['inputerror'][] = 'flowmeter_awal_2';
            $data['error_string'][] = 'Kolom Flow Meter Awal 2 Tidak Boleh Melebihi Kolom Flow Meter Akhir 2';
            $data['status'] = FALSE;
        }

        if(($this->input->post('flowmeter_awal_3') != NULL && $this->input->post('flowmeter_akhir_3') != NULL) && ($this->input->post('flowmeter_awal_3') > $this->input->post('flowmeter_akhir_3')))
        {
            $data['inputerror'][] = 'flowmeter_awal_3';
            $data['error_string'][] = 'Kolom Flow Meter Awal 3 Tidak Boleh Melebihi Kolom Flow Meter Akhir 3';
            $data['status'] = FALSE;
        }

        if(($this->input->post('flowmeter_awal_4') != NULL && $this->input->post('flowmeter_akhir_4') != NULL) && ($this->input->post('flowmeter_awal_4') > $this->input->post('flowmeter_akhir_4')))
        {
            $data['inputerror'][] = 'flowmeter_awal_4';
            $data['error_string'][] = 'Kolom Flow Meter Awal 4 Tidak Boleh Melebihi Kolom Flow Meter Akhir 4';
            $data['status'] = FALSE;
        }

        if($this->input->post('pengisi') == NULL)
        {
            $data['inputerror'][] = 'pengisi';
            $data['error_string'][] = 'Kolom Pengisi Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('flowmeter_awal') > $this->input->post('flowmeter_akhir'))
        {
            $data['inputerror'][] = 'flowmeter_awal';
            $data['error_string'][] = 'Kolom Flow Meter Awal Tidak Boleh Melebihi Kolom Flow Meter Akhir';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    private function _validate_pembayaran_laut() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('no_nota') == NULL)
        {
            $data['inputerror'][] = 'no_nota';
            $data['error_string'][] = 'Kolom No Nota Awal Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('no_faktur') == NULL)
        {
            $data['inputerror'][] = 'no_faktur';
            $data['error_string'][] = 'Kolom No Faktur Akhir Masih Kosong';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    //fungsi untuk membuat notifikasi
    public function cekNotifKapal(){
        $result = $this->data->notifKapal();
        echo json_encode($result);
    }

    //untuk membuat tampilan tabel status pengantaran transaksi darat dan realisasi pengisian air kapal
    public function tabel_pengantaran(){
        $tipe = $this->input->get('id');

        if($tipe == "darat"){
            $result = $this->data->get_tabel_transaksi($tipe);
            $data = array();
            $no = 1;

            foreach ($result as $row){
                $aksi = "";

                if($row->waktu_mulai_pengantaran == NULL){
                    $aksi = '&nbsp;<a class="btn btn-sm btn-info glyphicon glyphicon-road" href="javascript:void(0)" title="Pengantaran" onclick="pengantaran('."'".$row->id_transaksi."'".');"></a>';
                }else if($row->waktu_selesai_pengantaran != NULL){
                    $aksi = "";
                }else{
                    $aksi = '&nbsp;<a class="btn btn-sm btn-primary glyphicon glyphicon-ok" href="javascript:void(0)" title="Realisasi" onclick="realisasi('."'".$row->id_transaksi."'".')"></a>';
                }
                $format_tgl = date('d-m-Y H:i', strtotime($row->tgl_transaksi ));
                $format_tgl_pengantaran = date('d-m-Y H:i', strtotime($row->tgl_perm_pengantaran ));

                if($row->status_delivery == 1){
                    $status_pengantaran = "Sudah Diantar";
                }else if($row->waktu_mulai_pengantaran != NULL){
                    $status_pengantaran = "Sedang Dalam Pengantaran";
                }else{
                    $status_pengantaran = "Belum Diantar";
                }

                if(($row->status_pembayaran == 1 || $row->status_invoice == 1) && $row->status_delivery == 0 && $row->batal_nota == 0 && $row->batal_kwitansi == 0){
                    $data[] = array(
                        'no' => $no,
                        'nama' => $row->nama_pemohon,
                        'alamat' => $row->alamat,
                        'no_telp' => $row->no_telp,
                        'tanggal' => $format_tgl,
                        'tanggal_permintaan' => $format_tgl_pengantaran,
                        'total_pengisian' => $row->total_permintaan,
                        'status_pengantaran' => $status_pengantaran,
                        'aksi' => $aksi
                    );
                    $no++;
                }
            }
        }
        else{
            $result = $this->data->get_tabel_transaksi($tipe);
            $data = array();
            $no = 1;
            foreach ($result as $row){
                $aksi = "";
                if($row->flowmeter_awal == NULL && $row->flowmeter_akhir == NULL){
                    $aksi = '<a class="btn btn-sm btn-primary glyphicon glyphicon-download-alt" href="javascript:void(0)" title="Realisasi Pengisian" onclick="realisasi('."'".$row->id_transaksi."'".')"></a>';
                    $status = "Belum Di Isi";
                }else{
                    $aksi = "";
                    $status = "Sudah Di Isi";
                }

                if($row->voy_no == NULL){
                    $row->voy_no = "";
                }

                $format_tgl = date('d-m-Y', strtotime($row->tgl_transaksi ));

                if($row->flowmeter_awal == NULL && $row->flowmeter_akhir == NULL){
                    $data[] = array(
                        'no' => $no,
                        'id_kapal' => $row->id_vessel,
                        'nama_lct' => $row->nama_vessel,
                        'voy_no' => $row->voy_no,
                        'nama_perusahaan' => $row->nama_agent,
                        'nama_pemohon' => $row->nama_pemohon,
                        'tgl_transaksi' => $format_tgl,
                        'total_permintaan' => $row->total_permintaan." Ton",
                        'flow_sebelum' => "0",
                        'flow_sesudah' => "0",
                        'status' => $status,
                        'aksi' => $aksi
                    );
                    $no++;
                }
            }
        }

        echo json_encode($data);
    }

    function cetakPengisian(){
        $id = $this->input->get('id');
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        $query = $this->data->cetakkwitansi("laut",$id);

        $tanggal = $this->indonesian_date('d M Y', '','');
        $tgl_transaksi = $this->indonesian_date('l, d M Y', $query->tgl_transaksi,'');

        if($query->flowmeter_akhir_4 != NULL && $query->flowmeter_awal_4 != NULL){
            $realisasi = $query->flowmeter_akhir_4 - $query->flowmeter_awal_4;
            if($query->flowmeter_akhir_3 != NULL && $query->flowmeter_awal_3 != NULL){
                $realisasi += $query->flowmeter_akhir_3 - $query->flowmeter_awal_3;
                if($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL){
                    $realisasi += $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
                }
            }
            $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
        } else if($query->flowmeter_akhir_3 != NULL && $query->flowmeter_awal_3 != NULL){
            $realisasi = $query->flowmeter_akhir_3 - $query->flowmeter_awal_3;
            if($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL){
                $realisasi += $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
            }
            $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
        } else if($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL){
            $realisasi = $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
            $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
        } else{
            $realisasi = $query->flowmeter_akhir - $query->flowmeter_awal;
        }

        $hasil = array(
            'nama_perusahaan' => $query->nama_agent,
            'kapal' => $query->nama_vessel,
            'voy_no' => $query->voy_no,
            'tgl_transaksi' => $tgl_transaksi,
            'total_permintaan' => $query->total_permintaan,
            'flowmeter_sebelum' => $query->flowmeter_awal,
            'flowmeter_sesudah' => $query->flowmeter_akhir,
            'flowmeter_sebelum_2' => $query->flowmeter_awal_2,
            'flowmeter_sesudah_2' => $query->flowmeter_akhir_2,
            'flowmeter_sebelum_3' => $query->flowmeter_awal_3,
            'flowmeter_sesudah_3' => $query->flowmeter_akhir_3,
            'flowmeter_sebelum_4' => $query->flowmeter_awal_4,
            'flowmeter_sesudah_4' => $query->flowmeter_akhir_4,
            'realisasi' => $realisasi,
            'tanggal' => $tanggal
        );
        $data['hasil'] = $hasil;
        $this->load->view('v_pengisian', $data);
    }

    function cetakPengisianKapal(){
        $id = $this->input->get('id');
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        $query = $this->data->cetakkwitansi("laut",$id);

        $tanggal = date('d M Y', time());
        $tgl_transaksi = date('D, d M Y', strtotime($query->tgl_transaksi));
        $realisasi = $query->flowmeter_akhir - $query->flowmeter_awal;

        $hasil = array(
            'nama_perusahaan' => $query->nama_agent,
            'kapal' => $query->nama_vessel,
            'voy_no' => $query->voy_no,
            'tgl_transaksi' => $tgl_transaksi,
            'total_permintaan' => $query->total_permintaan,
            'flowmeter_sebelum' => $query->flowmeter_awal,
            'flowmeter_sesudah' => $query->flowmeter_akhir,
            'realisasi' => $realisasi,
            'tanggal' => $tanggal
        );
        $data['hasil'] = $hasil;
        $this->load->view('v_pengisian_kapal', $data);
    }

    function cetakPerhitungan(){
        $id = $this->input->get('id');
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        $query = $this->data->cetakkwitansi("laut",$id);

        $tanggal = $this->indonesian_date('d M Y', '','');

        if( ($query->flowmeter_akhir_4 != NULL && $query->flowmeter_awal_4 != NULL) || ($query->flowmeter_akhir_4 != 0 && $query->flowmeter_awal_4 != 0) ){
            $realisasi = $query->flowmeter_akhir_4 - $query->flowmeter_awal_4;
            if( ($query->flowmeter_akhir_3 != NULL && $query->flowmeter_awal_3 != NULL) || ($query->flowmeter_akhir_3 != 0 && $query->flowmeter_awal_3 != 0) ){
                $realisasi += $query->flowmeter_akhir_3 - $query->flowmeter_awal_3;

                if( ($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL) || ($query->flowmeter_akhir_2 != 0 && $query->flowmeter_awal_2 != 0) ){
                    $realisasi += $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
                    $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
                } else{
                    $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
                }
            }
            else if( ($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL) || ($query->flowmeter_akhir_2 != 0 && $query->flowmeter_awal_2 != 0) ){
                $realisasi += $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
                $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
            }
            else {
                $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
            }
        }
        else if( ($query->flowmeter_akhir_3 != NULL && $query->flowmeter_awal_3 != NULL) || ($query->flowmeter_akhir_3 != 0 && $query->flowmeter_awal_3 != 0) ){
            $realisasi = $query->flowmeter_akhir_3 - $query->flowmeter_awal_3;
            if( ($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL) || ($query->flowmeter_akhir_2 != 0 && $query->flowmeter_awal_2 != 0) ){
                $realisasi += $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
                $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
            }
            else {
                $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
            }
        }
        else if( ($query->flowmeter_akhir_2 != NULL && $query->flowmeter_awal_2 != NULL) || ($query->flowmeter_akhir_2 != 0 && $query->flowmeter_awal_2 != 0) ){
            $realisasi = $query->flowmeter_akhir_2 - $query->flowmeter_awal_2;
            $realisasi += $query->flowmeter_akhir - $query->flowmeter_awal;
        }
        else{
            $realisasi = $query->flowmeter_akhir - $query->flowmeter_awal;
        }

        if($query->diskon != NULL){
            $tarif = $query->tarif;
            $total = ($query->tarif * $realisasi) - (($query->diskon / 100) * ($query->tarif * $realisasi));
        }else{
            $tarif = $query->tarif;
            $total = $query->tarif * $realisasi;
        }

        if($total >= 250000 && $total <= 1000000){
            $materai = 3000;
            $total_bayar = $total + $materai;
            $terbilang = $this->terbilang($total_bayar);
            $total = $this->Ribuan($total);
            $total_bayar = $this->Ribuan($total_bayar);
            $materai = $this->Ribuan($materai);
        } else if($total > 1000000){
            $materai = 6000;
            $total_bayar = $total + $materai;
            $terbilang = $this->terbilang($total_bayar);
            $total = $this->Ribuan($total);
            $total_bayar = $this->Ribuan($total_bayar);
            $materai = $this->Ribuan($materai);
        } else {
            $materai = 0;
            $total_bayar = $total + $materai;
            $terbilang = $this->terbilang($total_bayar);
            $total = $this->Ribuan($total);
            $total_bayar = $this->Ribuan($total_bayar);
            $materai = $this->Ribuan($materai);
        }

        if($this->session->userdata('role') == 'operasi'){
            $this->data->updatePrint($id);
        }

        $hasil = array(
            'id_lct' => $query->id_vessel,
            'nama_kapal' => $query->nama_vessel,
            'voy_no' => $query->voy_no,
            'pelayaran' => $query->nama_agent,
            'realisasi' => $realisasi,
            'tarif' => $tarif,
            'diskon' => $query->diskon,
            'total' => $total,
            'materai' => $materai,
            'tgl_transaksi' => $this->indonesian_date('l, d M Y', $query->tgl_transaksi,''),
            'tanggal' => $tanggal,
            'nama_pemohon' => $query->nama_pemohon,
            'total_bayar' => $total_bayar,
            'terbilang' => $terbilang
        );
        $data['hasil'] = $hasil;
        $this->load->view('v_perhitungan', $data);
    }

}
?>