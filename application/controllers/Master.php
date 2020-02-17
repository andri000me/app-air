<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends MY_Controller{
    //fungsi untuk master data ruko
    public function delete_data_ruko($id){
        $this->tenant->delete_data("ruko",$id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_data_ruko(){
        $list = $this->master->get_datatables_ruko();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = "<center>".$no;
            $row[] = "<center>".$result->id_flowmeter;
            $row[] = "<center>".$result->nama_pengguna_jasa;
            $row[] = "<center>".$result->lokasi;
            $row[] = "<center>".$result->no_telp;
            $row[] = '<center><a class="btn btn-sm btn-primary" href="editRuko?id=' . $result->id_flowmeter . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                    <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Delete" onclick="delete_data_ruko('."'".$result->id_flowmeter."'".')"><i class="glyphicon glyphicon-pencil"></i> Delete</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tenant->count_all_ruko(),
            "recordsFiltered" => $this->tenant->count_filtered_ruko(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function input_data_ruko(){
        $id = $this->input->post('id_flow');
        $nama_ruko = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $no_telp = $this->input->post('no_telp');

        if(isset($id) && $id != NULL){
            $data_insert = array(
                'id_flowmeter'  => $id,
                'issued_at' => date("Y-m-d",time()),
                'issued_by' => $this->session->userdata('username')
            );
            $data_insert2 = array(
                'nama_pengguna_jasa' => $nama_ruko,
                'lokasi' => $alamat,
                'no_telp' => $no_telp,
                'master_flowmeter_id_flowmaster' => $id,
                'pengguna_jasa_id_tarif' => "1",
                'issued_at' => date("Y-m-d",time()),
                'issued_by' => $this->session->userdata('username')
            );
            $query = $this->db->insert('master_flowmeter',$data_insert);
            $this->db->insert('pembeli_darat',$data_insert2);

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }
            else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data gagal");
        }
        echo json_encode($message);
    }

    public function editRuko($id){
        //$id = $_GET['id'];
        $data['id'] = $id;
        $data['title'] = 'Edit Data Ruko';
        $this->db->from('master_flowmeter,pembeli_darat');
        $this->db->where('id_flowmeter = master_flowmeter_id_flowmaster');
        $this->db->where('id_flowmeter',$id);
        $query = $this->db->get();
        $result = $query->row();
        $data['isi'] = array(
            'id_flowmeter' => $result->id_flowmeter,
            'nama_ruko' => $result->nama_pengguna_jasa,
            'alamat' => $result->alamat,
            'no_telp' => $result->no_telp
        );
        echo json_encode($data);
        //$this->load->template('v_edit_ruko',$data);
    }

    public function edit_ruko(){
        $id = $this->input->post('idm');
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $no_telp = $this->input->post('no_telp');
        $data_edit = array(
            'id_flowmeter' => $id,
            'last_modified' => date("Y-m-d",time()),
            'modified_by' => $this->session->userdata('username')
        );
        $data_edit2 = array(
            'nama_pengguna_jasa' => $nama,
            'lokasi' => $alamat,
            'no_telp' => $no_telp,
            'last_modified' => date("Y-m-d",time()),
            'modified_by' => $this->session->userdata('username')
        );
        if($id != ""){
            $this->db->set($data_edit);
            $this->db->where('id_flowmeter', $id);
            $query = $this->db->update('master_flowmeter');

            $this->db->set($data_edit2);
            $this->db->where('master_flowmeter_id_flowmaster', $id);
            $this->db->update('pembeli_darat');

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data gagal");
        }
        echo json_encode($message);
    }

    //fungsi untuk master data darat
    public function delete_data_darat($id){
        $this->master->delete_data("darat",$id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_data_darat(){
        $list = $this->master->get_datatables_darat();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = "<center>".$no;
            $row[] = "<center>".$result->nama_pengguna_jasa;
            $row[] = "<center>".$result->alamat;
            $row[] = "<center>".$result->no_telp;
            if($result->pengguna_jasa_id_tarif == "2"){
                $result->pengguna_jasa_id_tarif = "Perorangan (KIK)";
            }else if($result->pengguna_jasa_id_tarif == "3"){
                $result->pengguna_jasa_id_tarif = "Perorangan (NON - KIK)";
            }else if($result->pengguna_jasa_id_tarif == "4"){
                $result->pengguna_jasa_id_tarif = "Perusahaan (KIK)";
            }else {
                $result->pengguna_jasa_id_tarif = "Perusahaan (NON - KIK)";
            }
            $row[] = "<center>".$result->pengguna_jasa_id_tarif;
            $row[] = "<center>".$result->npwp;
            $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="edit('."'".$result->id_pengguna_jasa."'".')" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master->count_all_darat(),
            "recordsFiltered" => $this->master->count_filtered_darat(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function input_data_darat(){
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $no_telp = $this->input->post('no_telp');
        $pengguna = $this->input->post('pengguna');
        $npwp = $this->input->post('npwp');

        if(isset($nama) && $nama != NULL && $alamat != NULL && $no_telp != NULL && $pengguna != NULL){
            $data_insert = array(
                'nama_pengguna_jasa' => $nama,
                'alamat' => $alamat,
                'no_telp' => $no_telp,
                'pengguna_jasa_id_tarif' => $pengguna,
                'npwp' => $npwp,
                'issued_at' => date("Y-m-d H:i:s",time()),
                'issued_by' => $this->session->userdata('username')
            );
            $query = $this->db->insert('pembeli_darat',$data_insert);

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }
            else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data gagal");
        }
        echo json_encode($message);
    }

    public function editDarat($id){
        //$id = $_GET['id'];
        $data['id'] = $id;
        $data['title'] = 'Edit Data Darat';
        $this->db->from('pembeli_darat');
        $this->db->where('id_pengguna_jasa',$id);
        $query = $this->db->get();
        $result = $query->row();
        
        $data = array(
            'id_pengguna' => $result->id_pengguna_jasa,
            'nama_pembeli' => $result->nama_pengguna_jasa,
            'alamat' => $result->alamat,
            'no_telp' => $result->no_telp,
            'pengguna' => $result->pengguna_jasa_id_tarif,
            'npwp' => $result->npwp,
        );
        echo json_encode($data);
        //$this->load->template('v_edit_darat',$data);
    }

    public function populatePenggunaDarat(){
        $data = $this->master->get_pengguna("darat","darat");
        echo json_encode($data);
    }

    public function edit_darat(){
        $id = $this->input->post('idm');
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $no_telp = $this->input->post('no_telp');
        $pengguna = $this->input->post('pengguna');
        $npwp = $this->input->post('npwp');

        $data_edit = array(
            'nama_pengguna_jasa' => $nama,
            'alamat' => $alamat,
            'no_telp' => $no_telp,
            'pengguna_jasa_id_tarif' => $pengguna,
            'npwp' => $npwp,
            'last_modified' => date("Y-m-d H:i:s",time()),
            'modified_by' => $this->session->userdata('username')
        );
        if($id != ""){
            $this->db->set($data_edit);
            $this->db->where('id_pengguna_jasa', $id);
            $query = $this->db->update('pembeli_darat');

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data gagal");
        }
        echo json_encode($message);
    }

    //fungsi untuk master data laut
    public function delete_data_laut($id){
        $this->master->delete_data("laut",$id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_data_laut(){
        $list = $this->kapal->get_datatables_laut();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = "<center>".$no;
            $row[] = "<center>".$result->id_vessel;
            $row[] = "<center>".$result->nama_vessel;

            $data_agent = $this->master->getDataAgent($result->id_agent_master);

            $row[] = $data_agent->nama_agent;
            $row[] = $data_agent->alamat;
            $row[] = $data_agent->no_telp;

            $data_tarif = $this->master->getDataTarif($result->pengguna_jasa_id_tarif);

            $row[] = $data_tarif->tipe_pengguna_jasa;

            $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="edit('."'".$result->id_pengguna_jasa."'".')" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kapal->count_all_laut(),
            "recordsFiltered" => $this->kapal->count_filtered_laut(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function input_data_laut(){
        $id_lct = $this->input->post('id_lct');
        $nama = $this->input->post('nama_lct');
        $id_agent = $this->input->post('id_agent');
        $pengguna = $this->input->post('pengguna_jasa');

        if($nama != NULL && $id_agent != NULL && $pengguna != NULL){
            $data_insert = array(
                'id_vessel' => $id_lct,
                'nama_vessel' => $nama,
                'id_agent_master' => $id_agent,
                'pengguna_jasa_id_tarif' => $pengguna,
                'issued_at' => date("Y-m-d H:i:s",time()),
                'issued_by' => $this->session->userdata('username')
            );
            $query = $this->db->insert('pembeli_laut',$data_insert);

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }
            else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data error");
        }
        echo json_encode($message);
    }

    public function editLaut($id){
        //$id = $_GET['id'];
        $data['id'] = $id;
        $this->db->from('pembeli_laut,master_agent');
        $this->db->where('id_agent = id_agent_master');
        $this->db->where('id_pengguna_jasa',$id);
        $query = $this->db->get();
        $result = $query->row();        

        $data = array(
            'id_pengguna_jasa' =>$result->id_pengguna_jasa,
            'id_vessel' => $result->id_vessel,
            'nama_vessel' => $result->nama_vessel,
            'id_agent' => $result->id_agent_master,
            'alamat' => $result->alamat,
            'no_telp' => $result->no_telp,
            'pengguna' => $result->pengguna_jasa_id_tarif,
        );
        echo json_encode($data);
        //$this->load->template('v_edit_laut',$data);
    }

    public function populatePenggunaLaut(){
        $data = $this->master->get_pengguna("laut","laut");
        echo json_encode($data);
    }

    public function populateAgent(){
        $data = $this->master->getAgent();
        echo json_encode($data);
    }

    public function edit_laut(){
        $id = $this->input->post('idm');
        $id_lct = $this->input->post('id_lct');
        $nama = $this->input->post('nama_lct');
        $nama_perusahaan = $this->input->post('id_agent');
        $pengguna = $this->input->post('pengguna_jasa');
        $data_edit = array(
            'id_vessel' => $id_lct,
            'nama_vessel' => $nama,
            'id_agent_master' => $nama_perusahaan,
            'pengguna_jasa_id_tarif' => $pengguna,
            'last_modified' => date("Y-m-d H:i:s",time()),
            'modified_by' => $this->session->userdata('username')
        );
        if($id != ""){
            $this->db->set($data_edit);
            $this->db->where('id_pengguna_jasa', $id);
            $query = $this->db->update('pembeli_laut');

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data gagal");
        }
        echo json_encode($message);
    }

    public function cari_agent($id){
        //$id = $this->input->get('id');
        $query = $this->db->from('master_agent')
                        ->where('id_agent',$id)
                        ->get();
        $result = $query->row();
        $data = array(
            'alamat' => $result->alamat,
            'no_telp' => $result->no_telp,
        );

        echo json_encode($data);
    }

    //fungsi untuk master data tenant
    public function delete_data_tenant($id){
        $this->tenant->delete_data("tenant",$id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_data_tenant(){
        if($this->session->userdata('role_name') == 'admin'){
            $list = $this->tenant->get_datatables_tenant();
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $result) {
                $no++;
                $row = array();
                $row[] = "<center>".$no;
                $row[] = "<center>".$result->nama_tenant;
                $row[] = "<center>".$result->penanggung_jawab;
                $row[] = $result->lokasi;
                $row[] = $result->no_telp;
                if($result->status_aktif_tenant == 1)
                    $status = "Aktif";
                else
                    $status = "Tidak Aktif";
                $row[] = $status;
                $data_flow = $this->tenant->getIdFlowmeter($result->id_ref_flowmeter);
                if($data_flow == NULL)
                    $flowmeter = '';
                else
                    $flowmeter = $data_flow->id_flowmeter;
                $row[] = $flowmeter;
                $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="edit('."'".$result->id_tenant."'".')" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->tenant->count_all_tenant(),
                "recordsFiltered" => $this->tenant->count_filtered_tenant(),
                "data" => $data,
            );
        }
        else{
            $list = $this->tenant->get_datatables_tenant();
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $result) {
                $no++;
                $row = array();
                $row[] = "<center>".$no;
                $row[] = "<center>".$result->nama_tenant;
                $row[] = "<center>".$result->penanggung_jawab;
                $row[] = $result->lokasi;
                $row[] = $result->no_telp;
                if($result->status_aktif_tenant == 1)
                    $status = "Aktif";
                else
                    $status = "Tidak Aktif";
                $row[] = $status;
                $data_flow = $this->tenant->getIdFlowmeter($result->id_ref_flowmeter);
                $row[] = $data_flow->id_flowmeter;
                $row[] = '';
                //$row[] = '<center><a class="btn btn-sm btn-primary" href="editTenant?id=' . $result->id_tenant . '" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->tenant->count_all_tenant(),
                "recordsFiltered" => $this->tenant->count_filtered_tenant(),
                "data" => $data,
            );
        }

        //output to json format
        echo json_encode($output);
    }

    public function input_data_tenant(){
        if($this->session->userdata('role_name') == 'admin'){
            $nama_tenant = $this->input->post('nama_tenant');
            $penanggung_jawab = $this->input->post('penanggung_jawab');
            $alamat = $this->input->post('alamat');
            $status = $this->input->post('status_aktif');
            $no_telp = $this->input->post('no_telp');
            $id_flowmeter = $this->input->post('id_flowmeter');

            if($nama_tenant != NULL && $penanggung_jawab != NULL && $alamat != NULL){
                $data_insert = array(
                    'nama_tenant' => $nama_tenant,
                    'penanggung_jawab' => $penanggung_jawab,
                    'lokasi' => $alamat,
                    'no_telp' => $no_telp,
                    'status_aktif_tenant' => $status,
                    'id_ref_flowmeter' => $id_flowmeter,
                    'pengguna_jasa_id' => '1',
                    'issued_at' => date("Y-m-d H:i:s",time()),
                    'issued_by' => $this->session->userdata('username')
                );
                $query = $this->db->insert('master_tenant',$data_insert);

                if($query){
                    $message = array("status" => TRUE,"info" => "Simpan data sukses");
                }
                else{
                    $message = array("status" => FALSE,"info" => "Simpan data gagal");
                }
            }
            else{
                $message = array("status" => FALSE,"info" => "Simpan data error");
            }
        }

        echo json_encode($message);
    }

    public function editTenant($id){
        if($this->session->userdata('role_name') == 'admin'){
            //$id = $_GET['id'];
            $data['id'] = $id;
            $this->db->from('master_tenant');
            $this->db->where('id_tenant',$id);
            $query = $this->db->get();
            $result = $query->row();

            $data = array(
                'id_tenant' => $result->id_tenant,
                'nama_tenant' => $result->nama_tenant,
                'penanggung_jawab' => $result->penanggung_jawab,
                'status_aktif' => $result->status_aktif_tenant,
                'alamat' => $result->lokasi,
                'no_telp' => $result->no_telp,
                'id_flowmeter' => $result->id_ref_flowmeter,
            );
        }
        echo json_encode($data);
        //$this->load->template('v_edit_tenant',$data);
    }

    public function populateFlowmeter(){
        $data = $this->tenant->getFlowmeter();
        echo json_encode($data);
    }

    public function edit_tenant(){
        if($this->session->userdata('role_name') == 'admin'){
            $id = $this->input->post('idm');
            $nama_tenant = $this->input->post('nama_tenant');
            $penanggung_jawab = $this->input->post('penanggung_jawab');
            $alamat = $this->input->post('alamat');
            $status = $this->input->post('status_aktif');
            $no_telp = $this->input->post('no_telp');
            $id_flowmeter = $this->input->post('id_flowmeter');

            $data_edit = array(
                'nama_tenant' => $nama_tenant,
                'penanggung_jawab' => $penanggung_jawab,
                'lokasi' => $alamat,
                'no_telp' => $no_telp,
                'status_aktif_tenant' => $status,
                'id_ref_flowmeter' => $id_flowmeter,
                'modified_at' => date("Y-m-d H:i:s",time()),
                'modified_by' => $this->session->userdata('nama')
            );

            if($id != ""){
                $this->db->set($data_edit);
                $this->db->where('id_tenant', $id);
                $query = $this->db->update('master_tenant');

                if($query){
                    $message = array("status" => TRUE,"info" => "Simpan data sukses");
                }else{
                    $message = array("status" => FALSE,"info" => "Simpan data gagal");
                }
            }
            else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }

        echo json_encode($message);
    }

    public function cari_tenant($id){
        //$id = $this->input->get('id');
        $query = $this->db->from('master_tenant')
            ->where('id_tenant',$id)
            ->get();
        $result = $query->row();
        $data = array(
            'penanggung_jawab' => $result->penanggung_jawab,
            'lokasi' => $result->lokasi,
        );

        echo json_encode($data);
    }

    //master tandon
    //fungsi untuk master data tenant
    public function delete_data_tandon($id){
        $this->master->delete_data_tandon($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_data_tandon(){
        $list = $this->master->get_datatables_tandon();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = "<center>".$no;
            $row[] = "<center>".$result->nama_tandon;
            $row[] = "<center>".$result->lokasi;

            $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="edit('."'".$result->id."'".')" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                    &nbsp;<a class="btn btn-sm btn-danger" href="javascript:void(0);" onclick="delete_data('."'".$result->id."'".')" title="Edit"><i class="glyphicon glyphicon-delete"></i> Delete</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master->count_all_tandon(),
            "recordsFiltered" => $this->master->count_filtered_tandon(),
            "data" => $data,
            );

        //output to json format
        echo json_encode($output);
    }

    public function input_data_tandon(){
        $nama_tandon = $this->input->post('nama_tandon');
        $lokasi      = $this->input->post('lokasi');

        if($nama_tandon != NULL && $lokasi != NULL){
            $data_insert = array(
                'nama_tandon' => $nama_tandon,
                'lokasi' => $lokasi,
                'created_at' => date("Y-m-d H:i:s",time()),
                'created_by' => $this->session->userdata('nama')
            );
            $query = $this->db->insert('master_tandon',$data_insert);

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }
            else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data error");
        }

        echo json_encode($message);
    }

    public function editTandon($id){
        $data['id'] = $id;
        $this->db->from('master_tandon');
        $this->db->where('id',$id);
        $query = $this->db->get();
        $result = $query->row();

        $data = array(
            'idm' => $result->id,
            'nama_tandon' => $result->nama_tandon,
            'lokasi' => $result->lokasi,
        );
        
        echo json_encode($data);
    }

    public function edit_tandon(){
        $id = $this->input->post('idm');
        $nama_tandon = $this->input->post('nama_tandon');
        $lokasi = $this->input->post('lokasi');

        $data_edit = array(
            'nama_tandon' => $nama_tandon,
            'lokasi' => $lokasi,
            'modified_at' => date("Y-m-d H:i:s",time()),
            'modified_by' => $this->session->userdata('nama')
        );

        if($id != ""){
            $this->db->set($data_edit);
            $this->db->where('id', $id);
            $query = $this->db->update('master_tandon');

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data gagal");
        }

        echo json_encode($message);
    }

    //fungsi untuk master data lumpsum
    public function ajax_data_lumpsum(){
        $list = $this->master->get_datatables_lumpsum();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $result) {
            $date_now = strtotime(date('Y-m-d',time() ));
            $date_kadaluarsa = strtotime($result->waktu_kadaluarsa);

            $no++;
            $row = array();
            $row[] = "<center>".$no;
            $row[] = "<center>".$result->no_perjanjian;
            $row[] = "<center>".$result->perihal;
            $row[] = "<center>".$result->waktu_kadaluarsa;
            $row[] = "<center>Rp. ".$this->Ribuan($result->nominal);
            $nama = $this->tenant->getTenant($result->id_ref_tenant);
            $row[] = "<center>".$nama->nama_tenant;
            if($date_now < $date_kadaluarsa || $date_now == $date_kadaluarsa){
                $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="edit('."'".$result->id_lumpsum."'".')" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
            } else{
                $row[] = '';
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master->count_all_lumpsum(),
            "recordsFiltered" => $this->master->count_filtered_lumpsum(),
            "data" => $data,
        );


        //output to json format
        echo json_encode($output);
    }

    public function input_data_lumpsum(){
        $no_perjanjian = $this->input->post('no_perjanjian');
        $nama_perjanjian = $this->input->post('nama_perjanjian');
        $waktu_kadaluarsa = $this->input->post('waktu_kadaluarsa');
        $nominal = $this->input->post('nominal');
        $tenant = $this->input->post('tenant');

        if($no_perjanjian != NULL && $nama_perjanjian != NULL && $waktu_kadaluarsa != NULL && $nominal){
            $data_insert = array(
                'no_perjanjian' => $no_perjanjian,
                'perihal' => $nama_perjanjian,
                'waktu_kadaluarsa' => $waktu_kadaluarsa,
                'nominal' => $nominal,
                'id_ref_tenant' => $tenant,
                'issued_at' => date("Y-m-d H:i:s",time()),
                'issued_by' => $this->session->userdata('username')
            );
            $query = $this->db->insert('master_lumpsum',$data_insert);

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }
            else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data gagal");
        }

        echo json_encode($message);
    }

    public function editLumpsum($id){
        //$id = $_GET['id'];
        $data['idm'] = $id;
        //$data['title'] = 'Edit Data Lumpsum';
        $this->db->from('master_lumpsum');
        $this->db->where('id_lumpsum',$id);
        $query = $this->db->get();
        $result = $query->row();

        $data = array(
            'id_lumpsum' => $result->id_lumpsum,
            'no_perjanjian' => $result->no_perjanjian,
            'perihal' => $result->perihal,
            'waktu_kadaluarsa' => $result->waktu_kadaluarsa,
            'nominal' => $result->nominal,
            'id_tenant' => $result->id_ref_tenant,
        );
        echo json_encode($data);
        //$this->load->template('v_edit_lumpsum',$data);
    }

    public function populateLumpsum(){
        $data = $this->tenant->getIDTenant();
        echo json_encode($data);
    }

    public function edit_lumpsum(){
        $id = $this->input->post('idm');
        $no_perjanjian = $this->input->post('no_perjanjian');
        $nama_perjanjian = $this->input->post('nama_perjanjian');
        $waktu_kadaluarsa = $this->input->post('waktu_kadaluarsa');
        $nominal = $this->input->post('nominal');
        $tenant = $this->input->post('tenant');

        $data_edit = array(
            'no_perjanjian' => $no_perjanjian,
            'perihal' => $nama_perjanjian,
            'waktu_kadaluarsa' => $waktu_kadaluarsa,
            'nominal' => $nominal,
            'id_ref_tenant' => $tenant,
            'modified_at' => date("Y-m-d H:i:s",time()),
            'modified_by' => $this->session->userdata('nama')
        );

        if($id != ""){
            $this->db->set($data_edit);
            $this->db->where('id_lumpsum', $id);
            $query = $this->db->update('master_lumpsum');

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data error");
        }

        echo json_encode($message);
    }

    //fungsi untuk master data sumur
    public function ajax_data_sumur(){
        if($this->session->userdata('role_name') == 'admin'){
            $list = $this->tenant->get_datatables_sumur();
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $result) {
                $no++;
                $row = array();
                $row[] = "<center>".$no;
                $row[] = "<center>".$result->id_sumur;
                $row[] = "<center>".$result->nama_sumur;
                $row[] = "<center>".$result->lokasi;
                $row[] = "<center>".$result->debit_air;
                $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="edit('."'".$result->id_master_sumur."'".')" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->tenant->count_all_sumur(),
                "recordsFiltered" => $this->tenant->count_filtered_sumur(),
                "data" => $data,
            );
        }
        else{

        }

        //output to json format
        echo json_encode($output);
    }

    public function input_data_sumur(){
        if($this->session->userdata('role_name') == 'admin'){
            $id_sumur = $this->input->post('id_sumur');
            $nama_sumur = $this->input->post('nama_sumur');
            $lokasi = $this->input->post('lokasi');
            $debit = $this->input->post('debit_air');

            if($id_sumur != NULL && $nama_sumur != NULL && $lokasi != NULL){
                $data_insert = array(
                    'id_sumur' => $id_sumur,
                    'nama_sumur' => $nama_sumur,
                    'lokasi' => $lokasi,
                    'debit_air' => $debit,
                    'issued_at' => date("Y-m-d H:i:s",time()),
                    'issued_by' => $this->session->userdata('username')
                );
                $query = $this->db->insert('master_sumur',$data_insert);

                if($query){
                    $message = array("status" => TRUE,"info" => "Simpan data sukses");
                }
                else{
                    $message = array("status" => FALSE,"info" => "Simpan data gagal");
                }
            }
            else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }

        echo json_encode($message);
    }

    public function editSumur($id){
        //$id = $_GET['id'];
        $this->db->from('master_sumur');
        $this->db->where('id_master_sumur',$id);
        $query = $this->db->get();
        $result = $query->row();

        $data = array(
            'id' => $id,
            'id_sumur' => $result->id_sumur,
            'nama_sumur' => $result->nama_sumur,
            'lokasi' => $result->lokasi,
            'debit_air' => $result->debit_air,
        );
        echo json_encode($data);
        //$this->load->template('v_edit_sumur',$data);
    }

    public function edit_sumur(){
        $id = $this->input->post('idm');
        $id_sumur = $this->input->post('id_sumur');
        $nama_sumur = $this->input->post('nama_sumur');
        $lokasi = $this->input->post('lokasi');
        $debit = $this->input->post('debit_air');

        $data_edit = array(
            'id_sumur' => $id_sumur,
            'nama_sumur' => $nama_sumur,
            'lokasi' => $lokasi,
            'debit_air' => $debit,
            'modified_at' => date("Y-m-d H:i:s",time()),
            'modified_by' => $this->session->userdata('nama')
        );

        if($id != ""){
            $this->db->set($data_edit);
            $this->db->where('id_master_sumur', $id);
            $query = $this->db->update('master_sumur');

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data gagal");
        }

        echo json_encode($message);
    }

    //fungsi untuk master data pompa
    public function ajax_data_pompa(){
        if($this->session->userdata('role_name') == 'wtp' || $this->session->userdata('role_name') == 'admin'){
            $list = $this->tenant->get_datatables_pompa();
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $result) {
                $no++;
                $row = array();
                $row[] = "<center>".$no;
                $row[] = "<center>".$result->id_pompa;
                $row[] = "<center>".$result->nama_pompa;
                if($result->kondisi == 'baik')
                    $kondisi = 'Baik';
                else if($result->kondisi == 'kurang_baik')
                    $kondisi = "Kurang Baik";
                else
                    $kondisi = "Rusak";

                $row[] = "<center>".$kondisi;

                if($result->status_aktif == 1)
                    $status = "Aktif";
                else
                    $status = "Tidak Aktif";

                $row[] = "<center>".$status;
                $data_pompa = $this->tenant->getNamaSumur($result->id_ref_sumur);
                $row[] = "<center>".$data_pompa->id_sumur;
                $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="edit('."'".$result->id_master_pompa."'".')" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->tenant->count_all_pompa(),
                "recordsFiltered" => $this->tenant->count_filtered_pompa(),
                "data" => $data,
            );
        }
        else{

        }

        //output to json format
        echo json_encode($output);
    }

    public function input_data_pompa(){
        if($this->session->userdata('role_name') == 'wtp' || $this->session->userdata('role_name') == 'admin'){
            $id_pompa = $this->input->post('id_pompa');
            $nama_pompa = $this->input->post('nama_pompa');
            $kondisi = $this->input->post('kondisi');
            $id_sumur = $this->input->post('id_sumur');

            if($id_pompa != NULL && $nama_pompa != NULL){
                $data_insert = array(
                    'id_pompa' => $id_pompa,
                    'nama_pompa' => $nama_pompa,
                    'kondisi' => $kondisi,
                    'id_ref_sumur' => $id_sumur,
                    'issued_at' => date("Y-m-d H:i:s",time()),
                    'issued_by' => $this->session->userdata('username')
                );
                $query = $this->db->insert('master_pompa',$data_insert);

                if($query){
                    $message = array("status" => TRUE,"info" => "Simpan data sukses");
                }
                else{
                    $message = array("status" => FALSE,"info" => "Simpan data gagal");
                }
            }
            else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }

        echo json_encode($message);
    }

    public function editPompa($id){
        //$id = $_GET['id'];
        $data['id'] = $id;
        $this->db->from('master_pompa');
        $this->db->where('id_master_pompa',$id);
        $query = $this->db->get();
        $result = $query->row();

        $data = array(
            'id_master_pompa' => $result->id_master_pompa,
            'id_pompa' => $result->id_pompa,
            'nama_pompa' => $result->nama_pompa,
            'kondisi' => $result->kondisi,
            'status_aktif' => $result->status_aktif,
            'id_sumur' => $result->id_ref_sumur,
        );
        echo json_encode($data);
        //$this->load->template('v_edit_pompa',$data);
    }

    public function populateSumur(){
        $data = $this->tenant->getIDSumur();
        echo json_encode($data);
    }

    public function edit_pompa(){
        $id = $this->input->post('idm');
        $id_pompa = $this->input->post('id_pompa');
        $nama_pompa = $this->input->post('nama_pompa');
        $kondisi = $this->input->post('kondisi');
        $id_sumur = $this->input->post('id_sumur');
        $status = $this->input->post('status');

        $data_edit = array(
            'id_pompa' => $id_pompa,
            'nama_pompa' => $nama_pompa,
            'kondisi' => $kondisi,
            'status_aktif' => $status,
            'id_ref_sumur' => $id_sumur,
            'modified_at' => date("Y-m-d H:i:s",time()),
            'modified_by' => $this->session->userdata('username')
        );

        if($id != ""){
            $this->db->set($data_edit);
            $this->db->where('id_master_pompa', $id);
            $query = $this->db->update('master_pompa');

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data gagal");
        }

        echo json_encode($message);
    }

    //fungsi untuk master data flowmeter
    public function ajax_data_flowmeter(){
        if($this->session->userdata('role_name') == 'wtp' || $this->session->userdata('role_name') == 'admin'){
            $list = $this->tenant->get_datatables_flowmeter();
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $result) {
                $no++;
                $row = array();
                $row[] = "<center>".$no;
                $row[] = "<center>".$result->id_flowmeter;
                $row[] = "<center>".$result->nama_flowmeter;
                $row[] = "<center>".$result->flowmeter_awal;
                $row[] = "<center>".$result->flowmeter_akhir;
                if($result->kondisi == 'baik')
                    $kondisi = "Baik";
                else if($result->kondisi == 'kurang_baik')
                    $kondisi = "Kurang Baik";
                else
                    $kondisi = "Rusak";
                $row[] = $kondisi;

                if($result->status_aktif == 1)
                    $status = 'Aktif';
                else
                    $status = 'Tidak Aktif';
                $flowmeter = $this->tenant->getNamaPompa($result->id_flow);
                $row[] = "<center>".$flowmeter->id_pompa;
                $row[] = $status;
                $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="edit('."'".$result->id_flow."'".')" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->tenant->count_all_flowmeter(),
                "recordsFiltered" => $this->tenant->count_filtered_flowmeter(),
                "data" => $data,
            );
        }
        else{

        }

        //output to json format
        echo json_encode($output);
    }

    public function input_data_flowmeter(){
        if($this->session->userdata('role_name') == 'wtp' || $this->session->userdata('role_name') == 'admin'){
            $id_flowmeter = $this->input->post('id_flowmeter');
            $nama_flowmeter = $this->input->post('nama_flowmeter');
            $kondisi = $this->input->post('kondisi');
            $pompa = $this->input->post('id_pompa');

            if($id_flowmeter != NULL && $nama_flowmeter != NULL && $kondisi != NULL){
                $data_insert = array(
                    'id_flowmeter' => $id_flowmeter,
                    'nama_flowmeter' => $nama_flowmeter,
                    'kondisi' => $kondisi,
                    'id_ref_pompa' => $pompa,
                    'issued_at' => date("Y-m-d H:i:s",time()),
                    'issued_by' => $this->session->userdata('username')
                );
                $query = $this->db->insert('master_flowmeter',$data_insert);

                if($query){
                    $message = array("status" => TRUE,"info" => "Simpan data sukses");
                }
                else{
                    $message = array("status" => FALSE,"info" => "Simpan data gagal");
                }
            }
            else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{

        }

        echo json_encode($message);
    }

    public function editFlowmeter($id){
        //$id = $_GET['id'];
        //$data['id'] = $id;
        $this->db->from('master_flowmeter');
        $this->db->where('id_flow',$id);
        $query = $this->db->get();
        $result = $query->row();
        
        $data = array(
            'id' => $id,
            'id_flowmeter' => $result->id_flowmeter,
            'nama_flowmeter' => $result->nama_flowmeter,
            'status_aktif' => $result->status_aktif,
            'kondisi' => $result->kondisi,
            'id_pompa' => $result->id_ref_pompa,
            'flowmeter_awal' => $result->flowmeter_awal,
            'flowmeter_akhir' => $result->flowmeter_akhir,
        );
        echo json_encode($data);
        //$this->load->template('v_edit_flowmeter',$data);
    }

    public function populatePompa(){
        $data = $this->tenant->getPompa();
        echo json_encode($data);
    }

    public function edit_flowmeter(){
        $id = $this->input->post('idm');
        $id_flowmeter = $this->input->post('id_flowmeter');
        $nama_flowmeter = $this->input->post('nama_flowmeter');
        $kondisi = $this->input->post('kondisi');
        $status = $this->input->post('status_aktif');
        $flow_awal = $this->input->post('flowmeter_awal');
        $flow_akhir = $this->input->post('flowmeter_akhir');
        $pompa = $this->input->post('id_pompa');

        $data_edit = array(
            'id_flowmeter' => $id_flowmeter,
            'nama_flowmeter' => $nama_flowmeter,
            'status_aktif' => $status,
            'kondisi' => $kondisi,
            'flowmeter_awal' => $flow_awal,
            'flowmeter_akhir' => $flow_akhir,
            'id_ref_pompa' => $pompa,
            'last_modified' => date("Y-m-d H:i:s",time()),
            'modified_by' => $this->session->userdata('nama')
        );

        if($id != ""){
            $this->db->set($data_edit);
            $this->db->where('id_flow', $id);
            $query = $this->db->update('master_flowmeter');

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data gagal");
        }

        echo json_encode($message);
    }

    //fungsi untuk master data tarif
    public function delete_data_tarif($id){
        $this->data->delete_data_tarif($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_data_tarif(){
        $list = $this->master->get_datatables_tarif();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = "<center>".$no;
            $row[] = "<center>".$result->tipe_pengguna_jasa;
            $row[] = "<center>".$result->kawasan;
            $row[] = "<center>".$result->tipe;
            $row[] = "<center>".$result->tarif;
            $row[] = "<center>".$result->diskon;

            $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="edit('."'".$result->id_tarif."'".')" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master->count_all_tarif(),
            "recordsFiltered" => $this->master->count_filtered_tarif(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function input_data_tarif(){
        $tipe_pengguna = $this->input->post('tipe_pengguna');
        $kawasan = $this->input->post('kawasan');
        $tarif = $this->input->post('tarif');
        $tipe = $this->input->post('tipe');
        $diskon = $this->input->post('diskon');

        if(isset($tipe_pengguna)  && $tarif != NULL && $tipe != NULL ){
            $data_insert = array(
                'tipe_pengguna_jasa' => $tipe_pengguna,
                'kawasan' => $kawasan,
                'tipe' => $tipe,
                'tarif' => $tarif,
                'diskon' => $diskon,
                'issued_at' => date("Y-m-d H:i:s",time()),
                'issued_by' => $this->session->userdata('username')
            );
            $query = $this->db->insert('pengguna_jasa',$data_insert);

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }
            else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Inputan Masih Kosong");
        }
        echo json_encode($message);
    }

    public function editTarif($id){
        //$id = $_GET['id'];
        $data['id'] = $id;
        //$data['title'] = 'Edit Data Tarif';
        $this->db->from('pengguna_jasa');
        $this->db->where('id_tarif',$id);
        $query = $this->db->get();
        $result = $query->row();

        $data = array(
            'id_tarif' => $id,
            'tipe_pengguna_jasa' => $result->tipe_pengguna_jasa,
            'kawasan' => $result->kawasan,
            'tipe' => $result->tipe,
            'tarif' => $result->tarif,
            'diskon' => $result->diskon,
        );

        //$this->load->template('v_edit_tarif',$data);
        echo json_encode($data);
    }

    public function edit_tarif(){
        $id = $this->input->post('idm');
        $tipe_pengguna = $this->input->post('tipe_pengguna');
        $kawasan = $this->input->post('kawasan');
        $tarif = $this->input->post('tarif');
        $tipe = $this->input->post('tipe');
        $diskon = $this->input->post('diskon');
        $data_edit = array(
            'tipe_pengguna_jasa' => $tipe_pengguna,
            'kawasan' => $kawasan,
            'tipe' => $tipe,
            'tarif' => $tarif,
            'diskon' => $diskon,
            'last_modified' => date("Y-m-d H:i:s",time()),
            'modified_by' => $this->session->userdata('username')
        );
        if($id != ""){
            $this->db->set($data_edit);
            $this->db->where('id_tarif', $id);
            $query = $this->db->update('pengguna_jasa');

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Tidak Ada Inputan");
        }
        echo json_encode($message);
    }

    //fungsi untuk master data agent
    public function cariAgent(){
        $nama = $this->input->post('nama_perusahaan');
        $this->db->select('*');
        $this->db->from('master_agent');
        $this->db->where('nama_agent =', $nama);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            $result = $query->row();

            $data = array(
                'status' => 'success',
                'id' => $result->id_agent,
                'alamat' => $result->alamat,
                'telepon' => $result->no_telp,
            );
        }else{
            $data = array(
                'status' => 'failed'
            );
        }

        echo json_encode($data);
    }

    public function delete_data_agent($id){
        $this->master->delete_data_agent($id);
        echo json_encode(array("status" => TRUE));
    }

    public function ajax_data_agent(){
        $list = $this->master->get_datatables_agent();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $result) {
            $no++;
            $row = array();
            $row[] = "<center>".$no;
            $row[] = "<center>".$result->nama_agent;
            $row[] = "<center>".$result->alamat;
            $row[] = "<center>".$result->no_telp;
            $row[] = "<center>".$result->npwp;

            $row[] = '<center><a class="btn btn-sm btn-primary" href="javascript:void(0);" onclick="edit('."'".$result->id_agent."'".')" title="Edit"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                    ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master->count_all_agent(),
            "recordsFiltered" => $this->master->count_filtered_agent(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function input_data_agent(){
        $nama = $this->input->post('nama_perusahaan');
        $alamat = $this->input->post('alamat');
        $no_telp = $this->input->post('no_telp');
        $npwp = $this->input->post('npwp');

        if(isset($nama)  && $alamat != NULL && $npwp != NULL && $npwp != NULL){
            $data_insert = array(
                'nama_agent' => $nama,
                'alamat' => $alamat,
                'no_telp' => $no_telp,
                'npwp' => $npwp,
                'issued_at' => date("Y-m-d H:i:s",time()),
                'issued_by' => $this->session->userdata('username')
            );
            $query = $this->db->insert('master_agent',$data_insert);

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }
            else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => TRUE,"info" => "Inputan Masih Kosong");
        }
        echo json_encode($message);
    }

    public function editAgent($id){
        //$id = $_GET['id'];
        $data['id'] = $id;
        $data['title'] = 'Edit Data Tarif';
        $this->db->from('master_agent');
        $this->db->where('id_agent',$id);
        $query = $this->db->get();
        $result = $query->row();

        $data = array(
            'id_agent' => $result->id_agent,
            'nama_agent' => $result->nama_agent,
            'alamat' => $result->alamat,
            'no_telp' => $result->no_telp,
            'npwp' => $result->npwp,
        );
        echo json_encode($data);
        //$this->load->template('v_edit_agent',$data);
    }

    public function edit_agent(){
        $id = $this->input->post('idm');
        $nama = $this->input->post('nama_perusahaan');
        $alamat = $this->input->post('alamat');
        $no_telp = $this->input->post('no_telp');
        $npwp = $this->input->post('npwp');

        $data_edit = array(
            'nama_agent' => $nama,
            'alamat' => $alamat,
            'no_telp' => $no_telp,
            'npwp' => $npwp,
            'modified_at' => date("Y-m-d H:i:s",time()),
            'modified_by' => $this->session->userdata('username'),
        );

        if($id != ""){
            $this->db->set($data_edit);
            $this->db->where('id_agent', $id);
            $query = $this->db->update('master_agent');

            if($query){
                $message = array("status" => TRUE,"info" => "Simpan data sukses");
            }else{
                $message = array("status" => FALSE,"info" => "Simpan data gagal");
            }
        }
        else{
            $message = array("status" => FALSE,"info" => "Simpan data gagal");
        }
        echo json_encode($message);
    }

}

?>