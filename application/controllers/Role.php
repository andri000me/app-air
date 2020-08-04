<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MY_Controller{
    public function __construct() {
        parent::__construct();
        $this->ceksesi();
    }
    
    var $id_table = 'id_role';
    var $table    = 'role' ;

    //dokumen kapal
    public function ajax_list(){
        $list = $this->role->get_datatable();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $r) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$no;
            $row[] = '<center style="font-size: small">'.$r->nama_role;
            $row[] = '<center style="font-size: small">'.$r->role;
            $row[] = '<center><a class="btn btn-success" href="javascript:void(0)" title="Hak Akses" onclick="doc('."'".$r->id_role."'".')">H</a>
                    <a class="btn btn-info" href="javascript:void(0)" title="Edit" onclick="edit('."'".$r->id_role."'".')">E</a>
                    <a class="btn btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$r->id_role."'".')">X</a>';
            //add html for action
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->role->countAll(),
            "recordsFiltered" => $this->role->countFiltered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_edit($id){
		$data = $this->role->getData($id,$this->id_table,$this->table);
		echo json_encode($data);
    }

    public function ajax_save(){
        $this->_validate();
        $save = $this->input->post('save_method');
        $post = $_POST;

        $role = $this->db->escape_str($post['role']);
        $name = $this->db->escape_str($post['name']);
        
        
        $data = array(
            'role' => $role,
            'nama_role' => $name,
        );

        if($save == 'add'){
            if ($this->role->save_where($this->table,$data) > 0){
                echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
            }else{
                echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
            }
        }else{
            $id = $this->input->post('idm');
            if ($this->role->update_where($this->table ,array( $this->id_table => $id ), $data)){
                echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
            }else{
                echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
            }
        }
    }

    public function ajax_list_menu_table($id){
		$data = $this->role->getData($id,"role_id","user_access_menu");
		echo json_encode($data);
    }

    public function ajax_list_menu_access(){
        $id   = $this->input->post('id');
        $list = $this->menu->get_datatable();
        
        $data = array();
        $no   = $_POST['start'];

        foreach ($list as $r) {
            $menuAccess = $this->role->getAccessData($id,$r->id);
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$no;
            $row[] = '<center style="font-size: small">'.$r->title;
            if($r->parent_id != 0)
                $row[] = '<center style="font-size: small">'.$this->menu->parentMenuName($r->parent_id);
            else
                $row[] = '<center style="font-size: small">';
            
            if($menuAccess == TRUE){
                $row[] ="<center><div class='form-check'>
                <input class='form-check-input' checked type='checkbox' id='menuID' name='menuID[]' value='".$r->id."' />
                </div>";
            }else{
                $row[] ="<center><div class='form-check'>
                <input class='form-check-input' type='checkbox' id='menuID' name='menuID[]' value='".$r->id."' />
                </div>";
            }
            //add html for action
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->menu->countAll(),
            "recordsFiltered" => $this->menu->countFiltered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function delete($id){
        $this->role->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function getData(){
        $data = $this->role->getData();
        echo json_encode($data);
    }

    public function changeAccess() {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');
        
        $data = array();
        $menu = explode(',',$menu_id);

        for($i=0;$i<count($menu);$i++){
            $row = array(
                'role_id' => $role_id,
                'menu_id' => $menu[$i],
            );
            $data[] = $row;
        }
        $this->role->checkAccess($role_id);
        $result = $this->role->changeAccess($role_id,$data);
        //$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
        echo json_encode($result);
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('role') == NULL)
        {
            $data['inputerror'][] = 'role';
            $data['error_string'][] = 'role tidak boleh kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('name') == NULL)
        {
            $data['inputerror'][] = 'name';
            $data['error_string'][] = 'nama role tidak boleh kosong';
            $data['status'] = FALSE;
        }

        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }

}
?>


