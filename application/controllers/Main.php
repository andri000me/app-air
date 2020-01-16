<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title']='PT KKT APP-AIR';
        $this->load->template('v_main',$data);
    }

    //fungsi untuk pergantian view
    public function view() {
        $page = $_GET['id'];

        if($page == "darat"){
            $data['title'] = "Transaksi Darat";
            $data['pengguna'] = $this->data->get_pengguna("darat",$page);
            $this->load->template('v_input_darat',$data);
        }
        else if($page == "main_loket"){
            $data['title'] = "Dafter Permohonan";
            $this->load->template('v_main_loket',$data);
        }
        else if($page == "main_keuangan"){
            $data['title'] = "Dafter Tagihan Air Kapal";
            $this->load->template('v_main_keuangan',$data);
        }
        else if($page == "main_wtp"){
            $data['title'] = "Dafter Status Pengisian Kapal";
            $this->load->template('v_main_wtp',$data);
        }
        else if($page == "main_operasi"){
            $data['title'] = "Dafter Status Tagihan Air Kapal";
            $this->load->template('v_main_operasi',$data);
        }
        else if($page == "main_perencanaan"){
            $data['title'] = "Dafter Status Pelayanan Air Kapal";
            $this->load->template('v_main_perencanaan',$data);
        }
        else if($page == "laut"){
            $data['title'] = "Transaksi Laut";
            $data['pengguna'] = $this->data->get_pengguna("laut",$page);
            $this->load->template('v_input_laut',$data);
        }
        else if($page == "transaksi_darat"){
            $data['title'] = "Laporan Transaksi Darat";
            $this->load->template('v_laporan_transaksi_darat',$data);
        }
        else if($page == "transaksi_laut"){
            $data['title'] = "Laporan Transaksi Laut";
            $this->load->template('v_laporan_transaksi_laut',$data);
        }
        else if($page == "transaksi_ruko"){
            $data['title'] = "Laporan Transaksi Ruko";
            $this->load->template('v_laporan_transaksi_ruko',$data);
        }
        else if($page == "validasi_pembayaran_darat"){
            $data['title'] = "Validasi Pembayaran Air Darat";
            $data['pengguna'] = $this->data->get_pengguna("darat","darat");
            $this->load->template('v_validasi_pembayaran_darat',$data);
        }
        else if($page == "cancel_pembayaran_darat"){
            $data['title'] = "Pembatalan Pembayaran Air Darat";
            $data['pengguna'] = $this->data->get_pengguna("darat","darat");
            $this->load->template('v_batal_pembayaran_darat',$data);
        }
        else if($page == "cetak_laporan_darat"){
            $data['title'] = 'Laporan Pendapatan Air Darat'; //judul title
            $data['tipe'] = "darat";
            $this->load->template('v_laporan',$data);
        }
        else if($page == "cetak_laporan_laut"){
            $data['title'] = 'Laporan Pendapatan Air Kapal'; //judul title
            $data['tipe'] = "laut";
            $this->load->template('v_laporan',$data);
        }
        else if($page == "cetak_laporan_ruko"){
            $data['title'] = 'Laporan Pendapatan Air Ruko'; //judul title
            $data['tipe'] = "ruko";
            $this->load->template('v_laporan',$data);
        }
        else if($page == "cetak_laporan_flow"){
            $data['title'] = 'Laporan Pencatatan Flow Meter'; //judul title
            $data['tipe'] = "flow";
            $this->load->template('v_laporan',$data);
        }
        else if($page == "cetak_laporan_sumur"){
            $data['title'] = 'Laporan Pencatatan Sumur'; //judul title
            $data['tipe'] = "sumur";
            $this->load->template('v_laporan',$data);
        }
        else if($page == "monitoring_darat"){
            $data['title'] = 'Monitoring Layanan Jasa Air Darat'; //judul title
            $data['tipe'] = 'darat';
            $this->load->template('v_monitoring',$data);
        }
        else if($page == "monitoring_kapal"){
            $data['title'] = 'Monitoring Layanan Jasa Air Kapal'; //judul title
            $data['tipe'] = 'laut';
            $this->load->template('v_monitoring',$data);
        }
        else if($page == "tenant"){
            $data['title'] = 'Master Tenant'; //judul title
            if($this->session->userdata('role') == 'admin'){
                $data['tenant'] = $this->data->getFlowmeter();
                $this->load->template('v_tenant',$data);
            } else{
                $data['tenant'] = $this->data->getLumpsum();
                $this->load->template('v_tenant',$data);
            }
        }
        else if($page == "transaksi_tenant"){
            $data['title'] = 'Pencatatan Harian Tenant'; //judul title
            $this->load->template('v_input_ruko',$data);
        }
        else if($page == "flowmeter"){
            $data['title'] = 'Master Flow Meter'; //judul title
            $data['tenant'] = $this->data->getPompa();
            $this->load->template('v_flowmeter',$data);
        }
        else if($page == "sumur"){
            $data['title'] = 'Master Sumur'; //judul title
            $this->load->template('v_sumur',$data);
        }
        else if($page == "pompa"){
            $data['title'] = 'Master Pompa'; //judul title
            $data['tenant'] = $this->data->getIDSumur();
            $this->load->template('v_pompa',$data);
        }
        else if($page == "lumpsum"){
            $data['title'] = 'Master Lumpsum'; //judul title
            $data['lumpsum'] = $this->data->getIDTenant();
            $this->load->template('v_lumpsum',$data);
        }
        else if($page == "tagihan"){
            $data['title'] = 'Penagihan Ruko'; //judul title
            $this->load->template('v_tagihan',$data);
        }
        else if($page == "daftar_tagihan"){
            $data['title'] = 'Daftar Penagihan Ruko'; //judul title
            $this->load->template('v_tabel_penagihan',$data);
        }
        else if($page == "realisasi_pembayaran_darat"){
            $data['title'] = 'Realisasi Pembayaran Darat'; //judul title
            $this->load->template('v_realisasi_pembayaran_darat',$data);
        }
        else if($page == "realisasi_pembayaran_tenant"){
            $data['title'] = 'Realisasi Pembayaran Tenant'; //judul title
            $this->load->template('v_realisasi_pembayaran_tenant',$data);
        }
        else if($page == "riwayat_pencatatan_flow"){
            $data['title'] = 'Riwayat Pencatatan Flow Meter'; //judul title
            $this->load->template('v_riwayat_catat_flow',$data);
        }
        else if($page == "catat_sumur"){
            $data['title'] = 'Pencatatan Harian Sumur'; //judul title
            $this->load->template('v_pencatatan_sumur',$data);
        }
        else if($page == "riwayat_pencatatan_sumur"){
            $data['title'] = 'Riwayat Pencatatan Sumur'; //judul title
            $this->load->template('v_riwayat_catat_sumur',$data);
        }
        else{
            redirect('main');
        }

    }

    public function cekNotifDarat(){
        $result = $this->data->notifDarat();
        echo json_encode($result);
    }

    public function cekNotifAntar(){
        $result = $this->data->notifAntar();
        echo json_encode($result);
    }

    public function cekNotifRealisasi(){
        $result = $this->data->notifRealisasi();
        echo json_encode($result);
    }

    public function cekNotifBayar(){
        $result = $this->data->notifBayar();
        echo json_encode($result);
    }

    public function cekNotifBayarDarat(){
        $result = $this->data->notifBayarDarat();
        echo json_encode($result);
    }

    public function cekNotifBayarRuko(){
        $result = $this->data->notifBayarRuko();
        echo json_encode($result);
    }

    //fungsi manajemen user
    function login(){
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->data = array(
                'title' => "PT KKT - APP AIR",
            );
            $this->load->template('v_main',$this->data);
        }
        else {
            $key = "PTKKT2406";
            $session = md5($this->input->post('username').$key.$this->input->post('password').$key);
            $user = $this->data->login($session);  
            if ($user != NULL) {
                $session  = $user->session;
                $username = $user->username;
                $role  = $user->role;
                $password = $user->password;

                $session_data = array(
                    'sesi' => $session,
                    'session' => $session,
                    'username' => $username,
                    'password' => $password,
                    'role' => $role,
                    'nama' => $user->nama
                );

                // Add user data in session
                $this->session->set_userdata($session_data);
                $waktu = date("Y-m-d H:i:s", time());

                $data = array(
                    'username'   => $username,
                    'last_login'  => $waktu
                );

                $this->data->update_login($data);
                $data = array(
                    'title' => "PT KKT - APP AIR",
                );

                $this->load->template('v_main',$data);
            }
            else {
                $data = array(
                    'title' => "PT KKT - APP AIR",
                );

                $this->session->set_userdata('error_message','Username atau Password Anda Salah');
                $this->load->template('v_main', $data);
            }
        }
    }

    function logout(){
        $sess_array = array(
            'sesi',
            'session',
            'username',
            'password',
            'role',
            'nama'
        );
        $this->session->unset_userdata($sess_array);

        $data = array(
            'title' => "PT KKT - APP AIR"
        );
        $this->session->set_userdata('message_display','Anda Telah Berhasil Logout');
        $this->load->template('v_main', $data);
    }

    public function ajax_list() {
        $this->load->helper('url');

        $list = $this->data->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$person->id_user.'">';
            $row[] = $person->username;
            $row[] = $person->nama;
            $row[] = $person->role;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id_user."'".')"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id_user."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->data->count_all(),
            "recordsFiltered" => $this->data->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->data->get_data_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate();
        $key     = "PTKKT2406";
        $session = md5($this->input->post('username').$key.$this->input->post('pass').$key);
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('pass'),
            'nama' => $this->input->post('nama'),
            'role' => $this->input->post('role'),
            'session' => $session,
        );

        $insert = $this->data->save($data);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate();
        $key     = "PTKKT2406";
        $session = md5($this->input->post('username').$key.$this->input->post('pass').$key);
        $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('pass'),
            'nama' => $this->input->post('nama'),
            'role' => $this->input->post('role'),
            'session' => $session,
        );
        $waktu      = date("Y-m-d H:i:s", time());
        $data_waktu = array(
            'username'   => $this->input->post('username'),
            'last_updated'  => $waktu
        );
        $this->data->update_data($data_waktu);
        $this->data->update(array('id_user' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        $this->data->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->data->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('username') == NULL)
        {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Nama Akun Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('pass') == NULL)
        {
            $data['inputerror'][] = 'pass';
            $data['error_string'][] = 'Kata Sandi Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('role') == NULL)
        {
            $data['inputerror'][] = 'role';
            $data['error_string'][] = 'Hak Akses Masih Belum Dipilih';
            $data['status'] = FALSE;
        }

        if($this->input->post('confirm_pass') == NULL)
        {
            $data['inputerror'][] = 'confirm_pass';
            $data['error_string'][] = 'Konfirmasi Kata Sandi Masih Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('pass') != $this->input->post('confirm_pass'))
        {
            $data['inputerror'][] = 'pass';
            $data['error_string'][] = 'Kata Sandi dan Konfirmasi Kata Sandi Tidak Sama';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

    public function update_pass(){
        $key     = "PTKKT2406";
        $session = md5($this->input->post('username').$key.$this->input->post('password').$key);
        $waktu = date("Y-m-d H:i:s", time());

        $data  = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password'),
            'session' => $session,
            'last_modified' => $waktu
        );
        $this->db->where('username', $data['username']);
        $update = $this->db->update('users', $data);

        if ($update) {
            return true;
        } else {
            return false;
        }
    }
}

?>
