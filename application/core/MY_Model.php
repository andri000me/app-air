<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Model extends CI_Model {
    var $table;
    var $column_order; //set column field database for datatable orderable
    var $column_search; //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order; // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function _get_datatables_query()
    {
        $this->db->from($this->table);

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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->where('soft_delete',0);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function update_where($table,$where, $data)
    {
        $query = $this->db->update($table, $data, $where);

        if($query)
            return  TRUE;
        else
            return FALSE;
    }

    public function save_where($table, $data)
    {
        $this->db->insert($table, $data);

        $status = array(
            'insert_id' => $this->db->insert_id(),
            'status' => $this->db->affected_rows(),
        );

        return $status;
    }

    public function save_where_batch($table, $data)
    {
        $this->db->insert_batch($table, $data);

        $status = array(
            'insert_id' => $this->db->insert_id(),
            'status' => $this->db->affected_rows(),
        );

        return $status;
    }

    public function delete_by_id($id)
    {
        $this->db->update($this->table,'soft_delete = 1','id ='.$id);
        return $this->db->affected_rows();
        //$this->db->where('id', $id);
        //$this->db->delete($this->table);
    }

    public function delete_data($id,$id_table){
        $where = $id_table.' ='.$id;
        $this->db->update($this->table,'soft_delete = 1',$where);
        return $this->db->affected_rows();
    }
    
    public function get_by_id($where,$table) {
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();

        return $query->row();
    }

    public function getDataa($id = '',$primary_key = '',$table){
        if($id != '')
            $this->db->where($primary_key,$id);
        
        $this->db->where('soft_delete','0');
        $query = $this->db->get($table);

        if($query->num_rows() > 0){
            if($id != '')
                return $query->row();
            else
                return $query->result();
        }
    }

    public function getOption($input){
        $get_option_proc = "CALL GetOption(?)";
        $result = $this->db->query($get_option_proc, $input);
        if ($result !== NULL) {
            return $result;
        }
        return FALSE;
    }
    
}

?>
