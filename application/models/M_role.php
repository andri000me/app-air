<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_role extends MY_Model {
    var $table             = 'role';
    var $view              = 'vw_menu';

    var $column_order      = array('id_role','role','nama_role'); //set column field database for datatable orderable
    var $column_search     = array('id_role','role','nama_role'); //set column field database for datatable searchable
    var $order             = array('id_role' => 'asc'); // default order

    function get_datatables_query() {
        $this->db->from($this->table);
        $this->db->where('soft_delete','0');
        $i = 0;

        foreach ($this->column_search as $item) // loop column
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatable(){
        $this->get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function countFiltered() {
        $this->get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAll() {
        $this->db->from($this->table);
        $this->db->where('soft_delete','0');
        return $this->db->count_all_results();
    }

    public function getData($id = ''){
        $this->db->from($this->table);
        $this->db->where('soft_delete','0');
        
        if($id != '')
            $this->db->where('id_role',$id);
        
        $query = $this->db->get();

        if($query->num_rows() > 0){
            if($id != '')
                return $query->row();
            else
                return $query->result();
        }    
    }

    public function deleteData($id){
        $this->db->set('soft_delete','1');
        $this->db->where('id_role', $id);
        $this->db->update($this->table);

        return $this->db->affected_rows();
    }

    public function changeAccess($id,$data=array() ){
        $result = $this->db->get_where('user_access_menu', $id);

        if ($result->num_rows() < 1) {
            $this->db->insert_batch('user_access_menu', $data);
        }

        return TRUE;
    }

    public function checkAccess($id){
        $this->db->where('role_id',$id);
        $result = $this->db->delete('user_access_menu');

        return $result;
    }

    public function getAccessData($role_id,$menu_id){
        $this->db->from('user_access_menu');
        $this->db->where('role_id',$role_id);
        $this->db->where('menu_id',$menu_id);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return TRUE;
        }    
    }

}
?>
