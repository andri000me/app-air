<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_master extends MY_Model{
    var $tabel_darat            = 'pembeli_darat';
    var $tabel_laut             = 'pembeli_laut';
    var $tabel_pengguna         = 'pengguna_jasa';

    var $column_order_tarif = array(null,'tipe_pengguna_jasa',null,null, null,null); //set column field database for datatable orderable
    var $column_search_tarif = array('tipe_pengguna_jasa'); //set column field database for datatable searchable
    var $order_tarif = array('id_tarif' => 'desc');

    var $column_order_darat = array(null, 'id_pengguna_jasa','nama_pengguna_jasa',null,null, null); //set column field database for datatable orderable
    var $column_search_darat = array('id_pengguna_jasa','nama_pengguna_jasa'); //set column field database for datatable searchable
    var $order_darat = array('id_pengguna_jasa' => 'desc');

    var $column_order_laut = array(null, 'id_pengguna_jasa','nama_vessel',null,null, null,null,null, null); //set column field database for datatable orderable
    var $column_search_laut = array('id_pengguna_jasa','id_vessel','nama_vessel'); //set column field database for datatable searchable
    var $order_laut = array('id_pengguna_jasa' => 'desc');

    var $column_order_agent = array(null,'nama_agent',null,null); //set column field database for datatable orderable
    var $column_search_agent = array('nama_agent'); //set column field database for datatable searchable
    var $order_agent = array('id_agent' => 'desc');

    var $column_order_lumpsum = array(null,'no_perjanjian','perihal',null,null); //set column field database for datatable orderable
    var $column_search_lumpsum = array('no_perjanjian','perihal'); //set column field database for datatable searchable
    var $order_lumpsum = array('id_lumpsum' => 'asc');


    //fungsi database untuk master data agent
    public function get_datatables_agent()
    {
        $this->_get_datatables_query_agent();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query_agent()
    {

        $this->db->from("master_agent");
        $i = 0;

        foreach ($this->column_search_agent as $item) // loop column
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

                if(count($this->column_search_agent) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_agent[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_agent))
        {
            $order = $this->order_agent;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_filtered_agent()
    {
        $this->_get_datatables_query_agent();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_agent()
    {
        $this->db->from("master_agent");
        return $this->db->count_all_results();
    }

    public function getAgent(){
        $this->db->from("master_agent");
        $query = $this->db->get();

        return $query->result();
    }

    public function getDataAgent($id){
        $query = $this->db->select('*')
            ->from('master_agent')
            ->where('id_agent',$id)
            ->get();

        return $query->row();
    }

    public function delete_data_agent($id){
        $this->db->where('id_agent', $id);
        $this->db->delete("master_agent");
    }

    //fungsi database untuk master data tarif
    public function get_datatables_tarif()
    {
        $this->_get_datatables_query_tarif();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query_tarif()
    {

        $this->db->from("pengguna_jasa");
        $i = 0;

        foreach ($this->column_search_tarif as $item) // loop column
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

                if(count($this->column_search_tarif) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_tarif[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_tarif))
        {
            $order = $this->order_tarif;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_filtered_tarif()
    {
        $this->_get_datatables_query_tarif();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_tarif()
    {
        $this->db->from("pengguna_jasa");
        return $this->db->count_all_results();
    }

    public function delete_data_tarif($id)
    {
        $this->db->where('id_tarif', $id);
        $this->db->delete("pengguna_jasa");
    }

    public function getTarif(){
        $this->db->from("pengguna_jasa");
        $query = $this->db->get();

        return $query->result();
    }

    public function getDataTarif($id){
        $query = $this->db->select('*')
                        ->from('pengguna_jasa')
                        ->where('id_tarif',$id)
                        ->get();

        return $query->row();
    }

    //fungsi database untuk master data darat
    public function get_datatables_darat()
    {
        $this->_get_datatables_query_darat();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query_darat()
    {

        $this->db->from("pembeli_darat");
        $this->db->where("pengguna_jasa_id_tarif != 1");
        $i = 0;

        foreach ($this->column_search_darat as $item) // loop column
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

                if(count($this->column_search_darat) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_darat[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_darat))
        {
            $order = $this->order_darat;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_filtered_darat()
    {
        $this->_get_datatables_query_darat();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_darat()
    {
        $this->db->from("pembeli_darat");
        $this->db->where("pengguna_jasa_id_tarif !=", "1");
        return $this->db->count_all_results();
    }

    public function getDataPembeliDarat($id){
        $query = $this->db->select('*')
            ->from('pembeli_darat')
            ->where('id_pengguna_jasa',$id)
            ->get();

        return $query->row();
    }

    public function getDataPembeliLaut($id){
        $query = $this->db->select('*')
            ->from('pembeli_laut')
            ->where('id_pengguna_jasa',$id)
            ->get();

        return $query->row();
    }

    //fungsi database untuk master data lumpsum
    public function edit_master_lumpsum($data){
        $this->db->set('no_perjanjian',$data['no_perjanjian']);
        $this->db->set('nama_perjanjian',$data['nama_perjanjian']);
        $this->db->set('waktu_kadaluarsa',$data['waktu_kadaluarsa']);
        $this->db->set('nominal',$data['nominal']);
        $this->db->where('id_lumpsum',$data['id_lumpsum']);
        $query = $this->db->update('master_lumpsum');

        return $query->affected_rows();
    }

    public function get_datatables_lumpsum()
    {
        $this->_get_datatables_query_lumpsum();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query_lumpsum()
    {
        $this->db->from("master_lumpsum");

        $i = 0;

        foreach ($this->column_search_lumpsum as $item) // loop column
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

                if(count($this->column_search_lumpsum) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->where('id_lumpsum >','0');
            $this->db->order_by($this->column_order_lumpsum[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_lumpsum))
        {
            $order = $this->order_lumpsum;
            $this->db->where('id_lumpsum >','0');
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_filtered_lumpsum()
    {
        $this->_get_datatables_query_lumpsum();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_lumpsum()
    {
        $this->db->from("master_lumpsum");
        return $this->db->count_all_results();
    }

    public function getLumpsum(){
        $this->db->from('master_lumpsum');
        $this->db->where('waktu_kadaluarsa >=',date('Y-m=d',time() ));
        $query = $this->db->get();

        return $query->result();
    }

    public function getIdLumpsum($id){
        $this->db->from('master_lumpsum');
        $this->db->where('id_lumpsum',$id);
        $query = $this->db->get();

        return $query->row();
    }

    //fungsi database untuk delete data master pada ruko,darat dan laut
    public function delete_data($tipe,$id)
    {
        if($tipe == "darat"){
            $this->db->where('id_pengguna_jasa', $id);
            $this->db->delete("pembeli_darat");
        } else{
            $this->db->where('id_pengguna_jasa', $id);
            $this->db->delete("pembeli_laut");
        }
    }

    public function get_no_pengguna($id){
        $query = $this->db->select('pengguna_jasa_id_tarif')
                    ->from($this->tabel_darat)
                    ->where('id_pengguna_jasa',$id)
                    ->get();
        $result = $query->result_array();
        $data = array_shift($result);
        return $data['pengguna_jasa_id_tarif'];
    }

    public function input_pengguna($tipe,$data){
        if($tipe == "darat"){
            $query = $this->db->insert($this->tabel_darat,$data);
        }else if($tipe == "ruko"){
            $query = $this->db->insert($this->tabel_darat,$data);
        }else{
            $query = $this->db->insert($this->tabel_laut,$data);
        }

        if($query){
            return TRUE;
        }
    }

    public function cek_pengguna($tipe, $nama){
        if($tipe == "darat"){
            $this->db->select('*');
            $this->db->from($this->tabel_darat);
            $this->db->where('nama_pengguna_jasa',$nama);
        }else if($tipe == "ruko"){

        }else{
            $this->db->select('*');
            $this->db->from($this->tabel_laut);
            $this->db->where('nama_vessel',$nama);
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) { //jika ada maka jalankan
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function getIDPengguna($nama){
        $this->db->from('pembeli_darat');
        $this->db->where('nama_pengguna_jasa',$nama);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_pengguna($tipe, $pengguna) {
        $this->db->select('*');
        $this->db->from($this->tabel_pengguna);
        $this->db->where('tipe', $tipe);

        if($pengguna == "darat"){
            $this->db->where('tipe_pengguna_jasa !=', 'Ruko');
            //$this->db->where('tipe_pengguna_jasa !=', 'Perusahaan (NON-KIK)');
            //$this->db->where('tipe_pengguna_jasa !=', 'Perusahaan (KIK)');
        } else if($pengguna == "darat_perusahaan"){
            $this->db->where('tipe_pengguna_jasa !=', 'Ruko');
            $this->db->where('tipe_pengguna_jasa !=', 'Perorangan (NON-KIK)');
            $this->db->where('tipe_pengguna_jasa !=', 'Perorangan (KIK)');
        } else if($pengguna == "ruko"){
            $this->db->where('tipe_pengguna_jasa =', 'Ruko');
        }else{

        }
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }

    //function untuk manajemen data transaksi pada aplikasi
    public function get_pembeli($tipe, $nama){
        if($tipe == "darat"){
            $tabel = $this->tabel_darat;
            $this->db->like('nama_pengguna_jasa', $nama);
            $this->db->from($tabel);
            $this->db->where('pengguna_jasa_id_tarif !=','1');
        }
        else if($tipe == "agent"){
            $this->db->like('nama_agent', $nama);
            $this->db->from('master_agent');
        }
        else{
            $this->db->like('nama_vessel', $nama);
            $this->db->from('pembeli_laut,master_agent');
            $this->db->where('id_agent = id_agent_master');
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) { //jika ada maka jalankan
            return $query->result();
        }
    }
}
?>