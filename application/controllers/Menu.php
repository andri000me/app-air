<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller{
    public function __construct() {
        parent::__construct();
        $this->ceksesi();
    }
    
    var $id_table = 'id';
    var $table    = 'table_menu' ;

    //dokumen kapal
    public function ajax_list(){
        $list = $this->menu->get_datatable();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $r) {
            $no++;
            $row = array();
            $row[] = '<center style="font-size: small">'.$no;
            $row[] = '<center style="font-size: small">'.$r->title;
            $row[] = '<center style="font-size: small">'.$r->url;
            $row[] = '<center style="font-size: small">'.$r->second_uri;
            if($r->is_active == 1)
                $row[] = '<center style="font-size: small">AKTIF';
            else
                $row[] = '<center style="font-size: small">NON AKTIF';
            
            $row[] = '<center style="font-size: small">'.$r->parent_menu;
            $row[] = '<center><a class="btn btn-info" href="javascript:void(0)" title="Edit" onclick="edit('."'".$r->id."'".')">E</a>
                    <a class="btn btn-danger" href="javascript:void(0)" title="Hapus" onclick="del('."'".$r->id."'".')">X</a>';
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

    public function ajax_edit($id){
		$data = $this->menu->getData($id,$this->id_table,$this->table);
		echo json_encode($data);
    }

    public function ajax_save(){
        $this->_validate();
        $save = $this->input->post('save_method');
        $post = $_POST;

        $title = $this->db->escape_str($post['title']);
        $uri = $this->db->escape_str($post['url']);
        
        if(!empty($_POST['status_aktif']))
            $status_aktif = $this->db->escape_str($post['status_aktif']);
        else
            $status_aktif = 0;
        
        $parent_menu = $this->db->escape_str($post['parent_menu']);
        
        $temp_second_uri = explode("/",$uri);
        $second_uri = $temp_second_uri[0];
        
        $data = array(
            'parent_id'     => $parent_menu,
            'title'         => $title,
            'url'           => $uri,
            'second_uri'    => $second_uri,
            'is_active'     => $status_aktif,
        );

        if($save == 'add'){
            if ($this->menu->save_where($this->table,$data) > 0){
                echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
            }else{
                echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
            }
        }else{
            $id = $this->input->post('idm');
            if ($this->menu->update_where($this->table ,array( $this->id_table => $id ), $data)){
                echo json_encode(array("status" => TRUE,"info" => "Simpan data sukses"));
            }else{
                echo json_encode(array("status" => FALSE,"info" => "Simpan data gagal"));
            }
        }
    }

    public function delete($id){
        $this->menu->deleteData($id);
        echo json_encode(array("status" => TRUE));
    }

    public function getData(){
        $data = $this->menu->getSeal();
        echo json_encode($data);
    }

    public function getParentMenu(){
        $data = $this->menu->getParentMenu();
        echo json_encode($data);
    }

    private function _validate() {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if($this->input->post('title') == NULL)
        {
            $data['inputerror'][] = 'title';
            $data['error_string'][] = 'judul menu tidak boleh kosong';
            $data['status'] = FALSE;
        }

        if($this->input->post('url') == NULL)
        {
            $data['inputerror'][] = 'url';
            $data['error_string'][] = 'url tidak boleh kosong';
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


