<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Darat extends MY_Controller {
    //fungsi untuk transaksi darat
    public function get_pembeli_darat() {
        $nama = $this->input->get('term'); //variabel kunci yang di bawa dari input text id kode
        $tipe = "darat";
        $query = $this->master->get_pembeli($tipe,$nama); //query model

        if($query == TRUE){
            $pelanggan = array();
            foreach ($query as $data) {
                $pelanggan[]     = array(
                    'label'   => $data->nama_pengguna_jasa, //variabel array yg dibawa ke label ketikan kunci
                    'id'      => $data->id_pengguna_jasa,
                    'nama'    => $data->nama_pengguna_jasa , //variabel yg dibawa ke id nama
                    'alamat'  => $data->alamat, //variabel yang dibawa ke id alamat
                    'no_telp' => $data->no_telp, //variabel yang dibawa ke id no telp
                    'pengguna'=> $data->pengguna_jasa_id_tarif, //variabel yang dibawa ke id pengguna jasa
                );
            }
        }

        echo json_encode($pelanggan);      //data array yang telah kota deklarasikan dibawa menggunakan json
    }

    function check_equal_more($second_field,$first_field){
        if (  $second_field >= $first_field) {
            $this->form_validation->set_message('check_equal_more', 'Permintaan Tidak Boleh Lebih Dari Deposit');
            return false;
        }
        else {
            return true;
        }
    }

    public function transaksi_darat() {
        $result = NULL;
        $id_pengguna = $this->input->post('id_pengguna');
        $nama_pengguna = $this->input->post('nama_pembeli');
        $alamat = $this->input->post('alamat_pembeli');
        $no_telp = $this->input->post('no_telp');
        $pengguna = $this->input->post('pengguna');
        $nama_pemohon = $this->input->post('nama_pemohon');
        $tanggal = $this->input->post('tgl_permintaan');
        $tonnase = $this->input->post('tonnase');
        $pelunasan = $this->input->post('pelunasan');
        $data_tarif = $this->master->getDataTarif($pengguna);

        $this->form_validation->set_rules('nama_pembeli', 'Nama Pembeli', 'required');
        $this->form_validation->set_rules('alamat_pembeli', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'No Telepon', 'required');
        $this->form_validation->set_rules('pengguna', 'Jenis Pengguna Jasa', 'required');
        $this->form_validation->set_rules('nama_pemohon', 'Nama Pemohon', 'required');
        $this->form_validation->set_rules('tgl_permintaan', 'Tanggal Permintaan', 'required');
        $this->form_validation->set_rules('tonnase', 'Total Pengisian', 'required');

        $kwitansi = $this->data->get_no_kwitansi();
        $tgl_tahun = date("YYYY",time());

        if ($this->form_validation->run() == FALSE) {
            $data['title']='Aplikasi Pelayanan Jasa Air Bersih';
            $data['pengguna'] = $this->data->get_pengguna("darat","darat");
            $this->load->template('darat/v_input_darat',$data);
        }
        else {
            $cek_result = $this->master->cek_pengguna('darat',$nama_pengguna);
            $result = FALSE;

            if($kwitansi != NULL ){
                $tahun = substr($tgl_tahun, 2, 2);
                $no_tahun = sprintf("%02s",$tahun);
                $no = (int) $kwitansi;
                if($no < 99999){
                    $no++;
                }
                else{
                    $no = 1;
                }
                $no_pengguna = $this->master->get_no_pengguna($id_pengguna);
                $no_kwitansi = $no_tahun.sprintf("%02s", $no_pengguna).sprintf("%05s", $no);
                $this->data->setNoKwitansi($no);
            }
            else{
                $tahun = substr($tgl_tahun, 2, 2);
                $no_tahun = sprintf("%02s",$tahun);
                $no = 1;
                $no_pengguna = $this->master->get_no_pengguna($id_pengguna);
                $no_kwitansi = $no_tahun.sprintf("%02s", $no_pengguna).sprintf("%05s", $no);
                $this->data->setNoKwitansi($no);
            }

            $data_pengguna = array(
                'nama_pengguna_jasa' => $nama_pengguna,
                'alamat' => $alamat,
                'no_telp' => $no_telp,
                'pengguna_jasa_id_tarif' => $pengguna,
                'issued_at' => date("Y-m-d H:i:s",time()),
                'issued_by' => $this->session->userdata('username')
            );

            if($cek_result == FALSE){
                $this->master->input_pengguna("darat",$data_pengguna);
            }
            else{
                if($pelunasan == "cash"){
                    $data_transaksi = array(
                        'pembeli_darat_id_pengguna_jasa' => $id_pengguna,
                        'nama_pemohon'=> $nama_pemohon,
                        'tgl_transaksi' => date('Y-m-d H:i:s',time()),
                        'tgl_perm_pengantaran' => date('Y-m-d H:i:s',strtotime($tanggal)),
                        'total_permintaan' => $tonnase,
                        'no_kwitansi' => $no_kwitansi,
                        'tarif' => $data_tarif->tarif,
                        'diskon' => $data_tarif->diskon,
                        'issued_at' => date("Y-m-d H:i:s",time()),
                        'issued_by' => $this->session->userdata('username')
                    );
                }
                else {
                    $status_invoice = 1;
                    $data_transaksi = array(
                        'pembeli_darat_id_pengguna_jasa' => $id_pengguna,
                        'nama_pemohon'=> $nama_pemohon,
                        'tgl_transaksi' => date('Y-m-d H:i:s',time()),
                        'tgl_perm_pengantaran' => date('Y-m-d H:i:s',strtotime($tanggal)),
                        'total_permintaan' => $tonnase,
                        'no_kwitansi' => $no_kwitansi,
                        'tarif' => $data_tarif->tarif,
                        'diskon' => $data_tarif->diskon,
                        'status_invoice' => $status_invoice,
                        'issued_at' => date("Y-m-d H:i:s",time()),
                        'issued_by' => $this->session->userdata('username')
                    );
                }
                $result = $this->darat->input_transaksi($data_transaksi);
            }

            if($result == FALSE){
                $id = $this->master->getIDPengguna($nama_pengguna);

                if($kwitansi != NULL ){
                    $tahun = substr($tgl_tahun, 2, 2);
                    $no_tahun = sprintf("%02s",$tahun);
                    $no = (int) $kwitansi;
                    if($no < 99999){
                        $no++;
                    }
                    else{
                        $no = 1;
                    }
                    $no_pengguna = $this->data->get_no_pengguna($id->id_pengguna_jasa);
                    $no_kwitansi = $no_tahun.sprintf("%02s", $no_pengguna).sprintf("%05s", $no);
                    $this->data->setNoKwitansi($no);
                }
                else{
                    $tahun = substr($tgl_tahun, 2, 2);
                    $no_tahun = sprintf("%02s",$tahun);
                    $no = 1;
                    $no_pengguna = $this->data->get_no_pengguna($id->id_pengguna_jasa);
                    $no_kwitansi = $no_tahun.sprintf("%02s", $no_pengguna).sprintf("%05s", $no);
                    $this->data->setNoKwitansi($no);
                }

                if($pelunasan == "cash"){
                    $data_transaksi = array(
                        'pembeli_darat_id_pengguna_jasa' => $id_pengguna,
                        'nama_pemohon'=> $nama_pemohon,
                        'tgl_transaksi' => date('Y-m-d H:i:s',time()),
                        'tgl_perm_pengantaran' => date('Y-m-d H:i:s',strtotime($tanggal)),
                        'total_permintaan' => $tonnase,
                        'no_kwitansi' => $no_kwitansi,
                        'tarif' => $data_tarif->tarif,
                        'diskon' => $data_tarif->diskon,
                        'issued_at' => date("Y-m-d H:i:s",time()),
                        'issued_by' => $this->session->userdata('username')
                    );
                }
                else {
                    $status_invoice = 1;
                    $data_transaksi = array(
                        'pembeli_darat_id_pengguna_jasa' => $id_pengguna,
                        'nama_pemohon'=> $nama_pemohon,
                        'tgl_transaksi' => date('Y-m-d H:i:s',time()),
                        'tgl_perm_pengantaran' => date('Y-m-d H:i:s',strtotime($tanggal)),
                        'total_permintaan' => $tonnase,
                        'no_kwitansi' => $no_kwitansi,
                        'tarif' => $data_tarif->tarif,
                        'diskon' => $data_tarif->diskon,
                        'status_invoice' => $status_invoice,
                        'issued_at' => date("Y-m-d H:i:s",time()),
                        'issued_by' => $this->session->userdata('username')
                    );
                }

                $this->db->select('*');
                $this->db->from('pembeli_darat');
                $this->db->where('nama_pengguna_jasa',$nama_pengguna);
                $query = $this->db->get();
                $result = $query->row();
                $data_transaksi['pembeli_darat_id_pengguna_jasa'] = $result->id_pengguna_jasa;
                $this->darat->input_transaksi($data_transaksi);
            }
        }

        if($result == TRUE){
            if($this->session->userdata('role_name') == 'admin')
                $web = base_url('main/darat/input_darat');
            else
                $web = base_url('main');
            echo "<script type='text/javascript'>
                    alert('Permintaan Berhasil Di Input')
                    window.location.replace('$web')
                </script>";
            //redirect('main/view?id=v_laporan_transaksi_darat');
        }else{
            $web = base_url('main/darat/input_darat');
            echo "<script type='text/javascript'>
                    alert('Permintaan Gagal Di Input ! Coba Lagi')
                    
                </script>";
            //redirect('main/view?id=v_input_darat');
        }
    }

    public function tabel_tagihan(){
        $result = $this->darat->get_tabel_transaksi();
        $data = array();
        $no = 1;
        $color = '';

        foreach ($result as $row){
            if($row->diskon != NULL || $row->diskon != 0){
                $row->tarif -= $row->diskon/100 * $row->tarif;
                $total_pembayaran = $row->tarif * $row->total_permintaan;
            }else{
                $total_pembayaran = $row->tarif * $row->total_permintaan;
            }

            $aksi = '<span class=""><a class="btn btn-primary glyphicon glyphicon-list-alt" title="realisasi pembayaran" onclick="realisasi('."'".$row->id_transaksi."'".');" target="_self" href="javascript:void(0)"> </a></span>';

            if($row->waktu_mulai_pengantaran == NULL){
                $row->waktu_mulai_pengantaran = "";
            }

            if($row->waktu_selesai_pengantaran == NULL){
                $row->waktu_selesai_pengantaran = "";
            }

            if($row->tgl_perm_pengantaran == NULL){
                $row->tgl_perm_pengantaran = "";
            }

            if($row->status_delivery == 1 && $row->soft_delete == 0 && $row->batal_nota == 0 && $row->batal_kwitansi == 0 && $row->status_invoice == 1){
                $data[] = array(
                    'no' => $no,
                    'nama_pelanggan' => $row->nama_pengguna_jasa." / ".$row->nama_pemohon,
                    'waktu_transaksi' => $row->tgl_transaksi,
                    'no_telp' => $row->no_telp,
                    'alamat' => $row->alamat,
                    'tarif' => $this->Ribuan($row->tarif),
                    'total_pengisian' => $row->total_permintaan,
                    'pembayaran' => $this->Ribuan($total_pembayaran),
                    'aksi' => $aksi,
                    'color' => $color
                );
                $no++;
            }
        }

        echo json_encode($data);
    }

    public function cancelTransaksiDarat(){
        $data['tipe'] = "darat";
        $data['id'] = $this->input->post('id');
        $this->darat->cancelOrder($data);
    }

    public function validasi_pembayaran_darat(){
        $id = $this->input->post('no_kwitansi');
        $this->form_validation->set_rules('no_kwitansi', 'No Kwitansi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['title']='Aplikasi Pelayanan Jasa Air Bersih';
            $this->load->template('pembayaran/v_pembayaran_darat_cash',$data);
        }else{
            $validasi = $this->data->get_data_kwitansi($id);

            if($validasi == TRUE){
                $this->db->set('status_pembayaran', 1);
                $this->db->set('status_invoice', 0);
                $this->db->set('last_modified',date("Y-m-d H:i:s",time()));
                $this->db->set('modified_by',$this->session->userdata('username'));
                $this->db->where('no_kwitansi', $id);
                $query = $this->db->update('transaksi_darat');

                if($query){
                    $web = base_url('main/pembayaran/pembayaran_darat_cash');
                    echo "<script type='text/javascript'>
                        alert('No Kwitansi Berhasil Di Validasi')
                        window.location.replace('$web')
                    </script>";
                }else{
                    $web = base_url('main/pembayaran/pembayaran_darat_cash');
                    echo "<script type='text/javascript'>
                        alert('No Kwitansi Gagal Di Validasi ! Coba Lagi')
                        window.location.replace('$web')
                    </script>";
                }
            }else{
                $web = base_url('main/pembayaran/pembayaran_darat_cash');
                echo "<script type='text/javascript'>
                        alert('No Kwitansi Ini Sudah Di Validasi')
                        window.location.replace('$web')
                    </script>";
            }
        }
    }

    public function cancel_pembayaran_darat(){
        $data['tipe'] = "darat";
        $data['id'] = $this->input->post('no_kwitansi');
        $query = $this->darat->cancelNota($data);

        if($query){
            $web = base_url('main/pembayaran/pembayaran_darat_cash');
            echo "<script type='text/javascript'>
                        alert('No Kwitansi Berhasil Di Batalkan')
                        window.location.replace('$web')
                    </script>";
        }else{
            $web = base_url('main/pembayaran/pembayaran_darat_cash');
            echo "<script type='text/javascript'>
                        alert('No Kwitansi Gagal Di Batalkan ! Coba Lagi')
                        window.location.replace('$web')
                    </script>";
        }
    }

    public function cancelKwitansi(){
        $data['tipe'] = "darat";
        $data['id'] = $this->input->post('id');
        $this->darat->cancelKwitansi($data);
    }

    public function realisasi_pembayaran_darat(){
        $this->_validate_pembayaran_darat();
        $data = array(
            'id_ref_transaksi' => $this->input->post('id-transaksi'),
            'no_nota' => $this->input->post('no_nota'),
            'no_faktur' => $this->input->post('no_faktur'),
            'tgl_pembayaran' => date('Y-m-d H:i:s', time()),
            'issued_at' => date("Y-m-d H:i:s",time()),
            'issued_by' => $this->session->userdata('nama')
        );
        $this->darat->update_pembayaran_darat($this->input->post('id-transaksi'), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function cari(){
        $kwitansi = $this->input->post('kwitansi');
        $this->db->select('*');
        $this->db->from('transaksi_darat , pembeli_darat ,pengguna_jasa');
        $this->db->where('no_kwitansi =', $kwitansi);
        $this->db->where('pengguna_jasa_id_tarif !=', 1);
        $this->db->where('status_pembayaran =', 0);
        $this->db->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa');
        $this->db->where('pengguna_jasa_id_tarif = id_tarif');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            $result = $query->row();

            if($result->diskon != NULL || $result->diskon != 0){
                $total_pembayaran = ($result->tarif - ($result->tarif * $result->diskon/100)) * $result->total_permintaan;
            }else{
                $total_pembayaran = $result->tarif * $result->total_permintaan;
            }
            $format_tgl = date('d-m-Y H:i', strtotime($result->tgl_transaksi ));
            $format_tgl_permintaan = date('d-m-Y H:i',strtotime($result->tgl_perm_pengantaran));

            $data = array(
                'status' => 'success',
                'nama' => $result->nama_pengguna_jasa,
                'alamat' => $result->alamat,
                'telepon' => $result->no_telp,
                'pengguna' => $result->pengguna_jasa_id_tarif,
                'tanggal' => $format_tgl,
                'jam' => $format_tgl_permintaan,
                'tonnase' => $result->total_permintaan,
                'pembayaran' => $total_pembayaran
            );
        }else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function cari_batal(){
        $kwitansi = $this->input->post('kwitansi');
        $this->db->select('*');
        $this->db->from('transaksi_darat , pembeli_darat ,pengguna_jasa');
        $this->db->where('no_kwitansi =', $kwitansi);
        $this->db->where('pengguna_jasa_id_tarif !=', 1);
        $this->db->where('status_pembayaran =', 1);
        $this->db->where('status_delivery =', 0);
        $this->db->where('batal_nota =', 0);
        $this->db->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa');
        $this->db->where('pengguna_jasa_id_tarif = id_tarif');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            $result = $query->row();

            if($result->diskon != NULL || $result->diskon != 0){
                $total_pembayaran = ($result->tarif - ($result->tarif * $result->diskon/100)) * $result->total_permintaan;
            }else{
                $total_pembayaran = $result->tarif * $result->total_permintaan;
            }
            $format_tgl = date('d-m-Y H:i', strtotime($result->tgl_transaksi ));
            $format_tgl_permintaan = date('d-m-Y H:i',strtotime($result->tgl_perm_pengantaran));

            $data = array(
                'status' => 'success',
                'nama' => $result->nama_pengguna_jasa,
                'alamat' => $result->alamat,
                'telepon' => $result->no_telp,
                'pengguna' => $result->pengguna_jasa_id_tarif,
                'tanggal' => $format_tgl,
                'jam' => $format_tgl_permintaan,
                'tonnase' => $result->total_permintaan,
                'pembayaran' => $total_pembayaran
            );
        }else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function ubah_status_pengantaran(){
        $data['id'] = $this->input->post('id_transaksi');
        $data['waktu'] = date("Y-m-d H:i:s",time());
        $data['user'] = $this->session->userdata('nama');

        $this->darat->ubah_waktu_pengantaran($data);
        echo json_encode(array("status" => TRUE));
    }

    public function realisasi_pengantaran_darat($id) {
        $data = $this->darat->get_by_id($id);
        echo json_encode($data);
    }

    public function pembayaran_darat($id) {
        $data = $this->darat->get_by_id($id);
        echo json_encode($data);
    }

    public function update_realisasi_darat(){
        $this->_validate_realisasi_darat();
        $data = array(
            'realisasi_pengisian' => $this->input->post('realisasi'),
            'waktu_selesai_pengantaran' => date("Y-m-d H:i:s",time()),
            'pengantar' => $this->input->post('pengantar'),
            'status_delivery' => '1',
            'last_modified' => date("Y-m-d H:i:s",time()),
            'modified_by' => $this->session->userdata('username')
        );
        $this->darat->update_realisasi(array('id_transaksi' => $this->input->post('id-transaksi')), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate_realisasi_darat() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('realisasi') == NULL)
        {
            $data['inputerror'][] = 'realisasi';
            $data['error_string'][] = 'Kolom Realisasi Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('pengantar') == NULL)
        {
            $data['inputerror'][] = 'pengangar';
            $data['error_string'][] = 'Kolom Pengantar Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('realisasi') > $this->input->post('tonnase_air'))
        {
            $data['inputerror'][] = 'realisasi';
            $data['error_string'][] = 'Realisasi Pengisian Tidak Bisa Melebihi Yang Sudah Di Pesan';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    private function _validate_pembayaran_darat() {
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

    //untuk membuat tampilan tabel status pembayaran transaksi kapal,darat dan ruko
    public function tabel_pembayaran(){
        $tipe = $this->input->get('id');

        $result = $this->darat->get_tabel_transaksi();
        $data = array();
        $no = 1;

        foreach ($result as $row){
            $color = '';
            $aksi = "";
            if($row->diskon != NULL || $row->diskon != 0){
                $row->tarif -= $row->diskon/100 * $row->tarif;
                $total_pembayaran = $row->tarif * $row->total_permintaan;
            }else{
                $total_pembayaran = $row->tarif * $row->total_permintaan;
            }

            if($this->session->userdata('role_name') == 'loket' || $this->session->userdata('role_name') == 'admin'){
                $aksi = '<a class="btn btn-primary glyphicon glyphicon-list-alt" title="Cetak Form Permintaan" target="_blank" href="'.base_url("darat/cetakFPermintaan/".$row->id_transaksi."").'"></a>&nbsp;';
            }

            if($row->batal_nota == 1){
                $aksi .= '<span class=""><a class="btn btn-danger glyphicon glyphicon-remove" title="batal kwitansi" target="_blank" href="javascript:void(0)" onclick="cancel_kwitansi('."'".$row->id_transaksi."'".');"> </a></span>';
                $color = '#ff0000';
            } else if($row->waktu_mulai_pengantaran == NULL || $row->waktu_selesai_pengantaran == NULL){
                $aksi .= '<span class=""><a class="btn btn-primary glyphicon glyphicon-list-alt" title="cetak kwitansi" target="_blank" href="'.base_url("darat/cetakKwitansi/".$row->id_transaksi."").'"> </a></span>';
                $aksi .= '&nbsp;<span class=""><a class="btn btn-danger glyphicon glyphicon-remove" title="batal transaksi" href="javascript:void(0)" onclick="batal('."'".$row->id_transaksi."'".');"></a></span>';
            } else{
                $aksi = "";
            }

            if($row->waktu_mulai_pengantaran == NULL){
                $row->waktu_mulai_pengantaran = "";
            }

            if($row->waktu_selesai_pengantaran == NULL){
                $row->waktu_selesai_pengantaran = "";
            }

            if($row->tgl_perm_pengantaran == NULL){
                $row->tgl_perm_pengantaran = "";
            }

            if($row->status_pembayaran == 0 && $row->batal_kwitansi == 0 && $row->status_invoice == 0){
                $data[] = array(
                    'no' => $no,
                    'nama' => $row->nama_pengguna_jasa." / ".$row->nama_pemohon,
                    'tgl_transaksi' => $row->tgl_transaksi,
                    'tgl_permintaan' => $row->tgl_perm_pengantaran,
                    'jenis' => $row->tipe_pengguna_jasa,
                    'tarif' => $this->Ribuan($row->tarif),
                    'total_pengisian' => $row->total_permintaan,
                    'total_pembayaran' => $this->Ribuan($total_pembayaran),
                    'waktu_mulai_pengantaran' => date("H:i:s", strtotime($row->waktu_mulai_pengantaran)),
                    'waktu_selesai_pengantaran' => date("H:i:s", strtotime($row->waktu_selesai_pengantaran)),
                    'aksi' => $aksi,
                    'color' => $color
                );
                $no++;
            }

        }
        
        echo json_encode($data);
    }

    //tampilan monitoring
    public function tabel_monitoring(){
        //$tipe = $this->input->get('id');
        $result = $this->darat->get_tabel_transaksi();
        $data = array();
        $no = 1;

        foreach ($result as $row){
            $aksi = "";

            if($row->waktu_mulai_pengantaran == NULL){
                $row->waktu_mulai_pengantaran = "";
            }
            else{
                $row->waktu_mulai_pengantaran = date("H:i:s", strtotime($row->waktu_mulai_pengantaran));
            }

            if($row->waktu_mulai_pengantaran == NULL || $row->waktu_selesai_pengantaran == NULL){
                if($row->status_invoice == 1){
                    $aksi .= '<span class=""><a class="btn btn-sm btn-primary glyphicon glyphicon-list-alt" title="Cetak Perhitungan" target="_blank" href="'.base_url("darat/cetakPerhitunganPiutang/".$row->id_transaksi."").'"> </a>&nbsp;</span>';
                    $aksi .= '<a class="btn btn-sm btn-info glyphicon glyphicon-list-alt" title="Cetak Form Permintaan" target="_blank" href="'.base_url("darat/cetakFPermintaan/".$row->id_transaksi."").'"></a>&nbsp;';
                    $aksi .= '<span class=""><a class="btn btn-sm btn-danger glyphicon glyphicon-remove" title="Batal Transaksi" href="javascript:void(0)" onclick="batal('."'".$row->id_transaksi."'".');"></a></span>';
                }
            } else {
                $aksi = "";
            }

            if($row->waktu_selesai_pengantaran == NULL){
                $row->waktu_selesai_pengantaran = "";
            }
            else{
                $row->waktu_selesai_pengantaran = date("H:i:s", strtotime($row->waktu_mulai_pengantaran));
            }

            if($row->tgl_perm_pengantaran == NULL){
                $row->tgl_perm_pengantaran = "";
            }

            if($row->status_invoice == "1"){
                $status_invoice = "Piutang";
            }else{
                $status_invoice = "Cash";
            }

            if($row->status_delivery == 0 && $row->batal_nota == 0 && $row->batal_kwitansi == 0){
                $data[] = array(
                    'no' => $no,
                    'nama' => $row->nama_pengguna_jasa." / ".$row->nama_pemohon,
                    'alamat' => $row->alamat,
                    'tgl_transaksi' => $row->tgl_transaksi,
                    'tgl_permintaan' => $row->tgl_perm_pengantaran,
                    'total_pengisian' => $row->total_permintaan,
                    'status_invoice' => $status_invoice,
                    'waktu_mulai_pengantaran' => $row->waktu_mulai_pengantaran,
                    'waktu_selesai_pengantaran' => $row->waktu_selesai_pengantaran,
                    'aksi' => $aksi
                );
                $no++;
            }
        }
        
        echo json_encode($data);
    }

    //untuk membuat tampilan tabel status pengantaran transaksi darat dan realisasi pengisian air kapal
    public function tabel_pengantaran(){
        $result = $this->darat->get_tabel_transaksi();
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
        
        echo json_encode($data);
    }

    function cetakKwitansi($id){
        //$id = $this->input->get('id');
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        $query = $this->darat->cetakkwitansi($id);
        $materai_1 = 3000;
        $materai_2 = 6000;
        $tanggal = $this->indonesian_date('d M Y', '','');
        $tgl_permintaan = $this->indonesian_date('l, d M Y', $query->tgl_perm_pengantaran,'');

        if($query->diskon != NULL || $query->diskon != 0){
            $t_sementara = (($query->tarif - ($query->diskon / 100 * $query->tarif)) * $query->total_permintaan);
            $tarif = $this->Ribuan($query->tarif - ($query->diskon / 100 * $query->tarif));
            $total_sementara = $this->Ribuan($t_sementara);
        }else{
            $t_sementara = ($query->tarif * $query->total_permintaan);
            $tarif = $this->Ribuan($query->tarif);
            $total_sementara = $this->Ribuan($t_sementara);
        }

        if($t_sementara >= 999999){
            $total = $this->Ribuan($t_sementara + $materai_2);
            $terbilang = $this->terbilang($t_sementara + $materai_2);
            $materai = $materai_2;
        }else if($t_sementara >= 249999 && $t_sementara < 999999){
            $total = $this->Ribuan($t_sementara + $materai_1);
            $terbilang = $this->terbilang($t_sementara + $materai_1);
            $materai = $materai_1;
        } 
        else{
            $total = $this->Ribuan($t_sementara);
            $terbilang = $this->terbilang($t_sementara);
            $materai = '';
        }

        $hasil = array(
            'nama_pelanggan' => $query->nama_pengguna_jasa,
            'nama_pemohon' => $query->nama_pemohon,
            'alamat' => $query->alamat,
            'tanggal' => $tanggal,
            'tgl_perm' => $tgl_permintaan,
            'total_pengisian' => $query->total_permintaan,
            'tarif' => $tarif,
            'total' => $total,
            'total_sementara' => $total_sementara,
            'materai' => $this->Ribuan($materai),
            'loket' => $this->session->userdata('nama'),
            'kwitansi' => $query->no_kwitansi,
            'terbilang' => $terbilang." Rupiah"
        );
        $data['hasil'] = $hasil;
        $this->load->view('darat/v_kwitansi', $data);
    }

    function cetakPerhitunganPiutang($id){
        //$id = $this->input->get('id');
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        $query = $this->darat->cetakkwitansi($id);

        $tanggal = $this->indonesian_date('l, d M Y', '','');
        $tgl_permintaan = date("d M Y", strtotime($query->tgl_perm_pengantaran));

        if($query->diskon != NULL || $query->diskon != 0){
            $tarif = $this->Ribuan($query->tarif - ($query->diskon / 100 * $query->tarif));
            $total = $this->Ribuan(($query->tarif - ($query->diskon / 100 * $query->tarif)) * $query->total_permintaan);
            $terbilang = $this->terbilang(($query->tarif - ($query->diskon / 100 * $query->tarif)) * $query->total_permintaan);
        }else{
            $tarif = $this->Ribuan($query->tarif);
            $total = $this->Ribuan($query->tarif * $query->total_permintaan);
            $terbilang = $this->terbilang($query->tarif * $query->total_permintaan);
        }


        $hasil = array(
            'nama_pelanggan' => $query->nama_pengguna_jasa,
            'nama_pemohon' => $query->nama_pemohon,
            'alamat' => $query->alamat,
            'tanggal' => $tanggal,
            'tgl_perm' => $tgl_permintaan,
            'total_pengisian' => $query->total_permintaan,
            'tarif' => $tarif,
            'total' => $total,
            'loket' => $this->session->userdata('nama'),
            'terbilang' => $terbilang." Rupiah"
        );
        $data['hasil'] = $hasil;
        $this->load->view('darat/v_perhitungan_piutang', $data);
    }

    function cetakFPermintaan($id){
        //$id = $this->input->get('id');
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        $query = $this->darat->cetakkwitansi($id);
        $tanggal = date('d M Y', strtotime($query->tgl_transaksi ));
        $jam = date('H.i',strtotime($query->tgl_transaksi));

        $hasil = array(
            'nama_pelanggan' => $query->nama_pengguna_jasa,
            'nama_pemohon' => $query->nama_pemohon,
            'alamat' => $query->alamat,
            'tanggal' => $tanggal,
            'total_pengisian' => $query->total_permintaan,
            'jam' => $jam,
            'no_telp' => $query->no_telp
        );
        $data['hasil'] = $hasil;
        $this->load->view('darat/v_form_permintaan', $data);
    }
    

}

?>