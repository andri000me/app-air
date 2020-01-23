<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller{
    //fungsi manajemen user
    function login(){
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->navmenu('APASIH KKT','v_login','','','');
        }
        else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->admin->login($username,$password);  
            if ($user['status'] == TRUE) {
                // Add user data in session
                $this->session->set_userdata($user);
                $waktu = date("Y-m-d H:i:s", time());

                $data = array(
                    'username'    => $username,
                    'last_login'  => $waktu
                );

                $this->admin->update_login($data);
                $data = array(
                    'title' => "PT KKT - APP AIR",
                );

                //$this->load->template('v_main',$data);
                redirect('main');
            }
            else {
                $data = array(
                    'title' => "PT KKT - APP AIR",
                );

                $this->session->set_userdata('error_message','Username atau Password Anda Salah');
                //$this->load->template('v_main', $data);
                redirect('main');
            }
        }
    }

    function logout(){
        $data = array(
            'status',
            'nama',
            'email',
            'username',
            'password',
            'role',
            'role_name',
            'created_date',
        );
        $this->session->unset_userdata($data);

        $data = array(
            'title' => "PT KKT - APP AIR"
        );
        $this->session->set_userdata('message_display','Anda Telah Berhasil Logout');
        //$this->load->template('v_main', $data);
        redirect('main');
    }

    public function ajax_list() {
        $list = $this->admin->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" class="data-check" value="'.$person->id_user.'">';
            $row[] = $person->username;
            $row[] = $person->nama;
            $row[] = $person->nama_role;

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->id_user."'".')"><i class="glyphicon glyphicon-pencil"></i> Ubah</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id_user."'".')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->admin->count_all(),
            "recordsFiltered" => $this->admin->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id) {
        $data = $this->admin->get_data_by_id($id);
        echo json_encode($data);
    }

    public function ajax_add() {
        $this->_validate_add();
        $data = array(
            'username' => $this->input->post('username'),
            'password' => password_hash($this->input->post('pass'), PASSWORD_DEFAULT),
            'nama'     => $this->input->post('nama'),
            'role'     => $this->input->post('role'),
        );

        $insert = $this->admin->save($data);
        $waktu      = date("Y-m-d H:i:s", time());
        $data_waktu = array(
            'username'      => $this->input->post('username'),
            'date_created'  => $waktu,
            'created_by'    => $this->session->username
        );
        $this->admin->create_data($data_waktu);

        echo json_encode(array("status" => TRUE));
    }

    public function ajax_update() {
        $this->_validate_edit();
        $pass = $this->input->post('pass');

        if($pass == '' || $pass == NULL){
            $data = array(
                'username' => $this->input->post('username'),
                'nama' => $this->input->post('nama'),
                'role' => $this->input->post('role'),
            );
        }else{
            $data = array(
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('pass'), PASSWORD_DEFAULT),
                'nama' => $this->input->post('nama'),
                'role' => $this->input->post('role'),
            );
        }
        

        $waktu      = date("Y-m-d H:i:s", time());
        $data_waktu = array(
            'username'      => $this->input->post('username'),
            'last_updated'  => $waktu,
            'modified_by'   => $this->session->username
        );
        $this->admin->update_data($data_waktu);
        $this->admin->update(array('id_user' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_delete($id) {
        //$this->data->delete_by_id($id);
        $this->admin->softDelete($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_bulk_delete() {
        $list_id = $this->input->post('id');
        foreach ($list_id as $id) {
            $this->data->delete_by_id($id);
        }
        echo json_encode(array("status" => TRUE));
    }

    private function _validate_add() {
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

        if($this->input->post('role') == NULL)
        {
            $data['inputerror'][] = 'role';
            $data['error_string'][] = 'Hak Akses Masih Belum Dipilih';
            $data['status'] = FALSE;
        }

        if($this->input->post('pass') == NULL)
        {
            $data['inputerror'][] = 'pass';
            $data['error_string'][] = 'Kata Sandi Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('confirm_pass') == NULL)
        {
            $data['inputerror'][] = 'confirm_pass';
            $data['error_string'][] = 'Konfirmasi Kata Sandi Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('pass') != $this->input->post('confirm_pass') && ($this->input->post('pass') != NULL) && $this->input->post('confirm_pass') != NULL)
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

    private function _validate_edit() {
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

        if($this->input->post('role') == NULL)
        {
            $data['inputerror'][] = 'role';
            $data['error_string'][] = 'Hak Akses Masih Belum Dipilih';
            $data['status'] = FALSE;
        }

        if($this->input->post('pass') != NULL && $this->input->post('confirm_pass') == NULL){
            $data['inputerror'][] = 'confirm_pass';
            $data['error_string'][] = 'Konfirmasi Kata Sandi Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('pass') == NULL && $this->input->post('confirm_pass') != NULL){
            $data['inputerror'][] = 'pass';
            $data['error_string'][] = 'Kata Sandi Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('pass') != $this->input->post('confirm_pass') && ($this->input->post('pass') != NULL) && $this->input->post('confirm_pass') != NULL)
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
        $waktu = date("Y-m-d H:i:s", time());
        $data  = array(
            'username'      => $this->input->post('username'),
            'password'      => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'last_modified' => $waktu
        );
        $result = $this->admin->changePass($data['username'],$data);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
?>