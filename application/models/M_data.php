<?php
class M_data extends MY_Model {
    var $table = 'users';
    
    var $column_order = array(null,'username', 'role',null); //set column field database for datatable orderable
    var $column_search = array('username'); //set column field database for datatable searchable just firstname , lastname , address are searchable
    var $order = array('id_user' => 'asc'); // default order

    function __construct() {
        parent::__construct();
    }

    public function get_no_kwitansi(){
        $this->db->from('reference');
        $this->db->where('nama','no_kwitansi');
        $query = $this->db->get();
        $result = $query->row();
        $data = $result->intVal;

        return $data;
    }

    public function setNoKwitansi($no){
        $this->db->set('intVal',$no);
        $this->db->where('nama','no_kwitansi');
        $this->db->update('reference');

        return $this->db->affected_rows();
    }

    public function get_no_invoice(){
        $this->db->from('reference');
        $this->db->where('nama','no_invoice');
        $query = $this->db->get();
        $result = $query->row();
        $data = $result->intVal;

        return $data;
    }

    public function setNoInvoice($no){
        $this->db->set('intVal',$no);
        $this->db->where('nama','no_invoice');
        $this->db->update('reference');

        return $this->db->affected_rows();
    }

    //function untuk manajamen data user di database
    public function login($id){
        $query = $this->db->select('*')
            ->from('users')
            ->where('session',$id)
            ->get();
        //$this->db->set('last_login',date("Y-m-d",time()));
        //$this->db->where("session", $id);
        //$this->db->update('users');
        if($query->num_rows() > 0){
            return $query->row();
        }
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
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function get_data_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id_user',$id);
        $query = $this->db->get();

        return $query->row();
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

    public function delete_by_id($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete($this->table);
    }

    public function update_login($data){
        $condition = "username =" . "'" . $data['username'] . "'";
        $this->db->select('last_login');
        $this->db->from('users');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        $login_data = array(
            'last_login' => $data['last_login']
        );

        if ($query->num_rows() == 1) {
            // Query to insert data in database
            $this->db->where($condition);
            $this->db->update('users', $login_data);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function update_data($data){
        $condition = "username =" . "'" . $data['username'] . "'";
        $this->db->select('last_modified');
        $this->db->from('users');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        $login_data = array(
            'last_modified' => $data['last_updated']
        );

        if ($query->num_rows() == 1) {
            // Query to insert data in database
            $this->db->where($condition);
            $this->db->update('users', $login_data);
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        } else {
            return false;
        }
    }

    //fungsi database untuk notifikasi
    public function notifDarat(){
        $where = "(status_pembayaran='1' OR status_invoice='1')";
        $this->db->select("*");
        $this->db->from('transaksi_darat');
        $this->db->where($where);
        $this->db->where('status_delivery =',0);
        $this->db->where('batal_kwitansi =',0);
        $this->db->where('soft_delete =',0);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function notifKapal(){
        $null = NULL;
        $this->db->select("*");
        $this->db->from('transaksi_laut');
        $this->db->where('flowmeter_awal =',$null);
        $this->db->where('flowmeter_akhir =',$null);
        $this->db->where('soft_delete =',0);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function notifAntar(){
        $this->db->select("*");
        $this->db->from('transaksi_darat');
        $this->db->where('status_delivery =',0);
        $this->db->where('batal_kwitansi =',0);
        $this->db->where('soft_delete =',0);
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function notifRealisasi(){
        $this->db->select("*");
        $this->db->from('transaksi_laut');
        $this->db->where('flowmeter_awal =',NULL);
        $this->db->where('flowmeter_akhir =',NULL);
        $this->db->where('soft_delete =',0);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function notifBayar(){
        $this->db->select("*");
        $this->db->from('transaksi_laut');
        $this->db->where('flowmeter_awal !=',NULL);
        $this->db->where('flowmeter_akhir !=',NULL);
        $this->db->where('status_invoice = 1');
        $this->db->where('soft_delete =', 0);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function notifBayarRuko(){
        $this->db->select("*");
        $this->db->from('transaksi_tenant');
        $this->db->where('status_invoice = 1');
        $this->db->where('soft_delete =', 0);

        $query = $this->db->get();

        return $query->num_rows();
    }

    public function notifBayarDarat(){
        $this->db->select("*");
        $this->db->from('transaksi_darat');
        $this->db->where('status_invoice =', 1);
        $this->db->where('status_delivery =', 1);
        $this->db->where('soft_delete =', 0);
        $this->db->where('batal_kwitansi =',0);

        $query = $this->db->get();

        return $query->num_rows();
    }

}
?>