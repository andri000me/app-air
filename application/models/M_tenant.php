<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tenant extends MY_Model{
    var $tabel_transaksi_ruko   = 'pencatatan_flow';

    var $column_order_ruko = array(null, 'id_flowmeter','nama_pengguna_jasa', null); //set column field database for datatable orderable
    var $column_search_ruko = array('id_flowmeter','nama_pengguna_jasa'); //set column field database for datatable searchable
    var $order_ruko = array('id_flowmeter' => 'desc');

    var $column_order_tenant = array(null,'nama_tenant',null,null,null,null,null,null); //set column field database for datatable orderable
    var $column_search_tenant = array('nama_tenant','penanggung_jawab'); //set column field database for datatable searchable
    var $order_tenant = array('nama_tenant' => 'asc');

    var $column_order_flowmeter = array(null,'id_flowmeter','nama_flowmeter',null,null,null,null); //set column field database for datatable orderable
    var $column_search_flowmeter = array('id_flowmeter','nama_flowmeter'); //set column field database for datatable searchable
    var $order_flowmeter = array('id_flowmeter' => 'asc');

    var $column_order_sumur = array(null,'id_sumur','nama_sumur',null,null,null,null); //set column field database for datatable orderable
    var $column_search_sumur = array('id_sumur','nama_sumur'); //set column field database for datatable searchable
    var $order_sumur = array('id_master_sumur' => 'asc');

    var $column_order_pompa = array(null,'id_pompa','nama_pompa',null,null,null,null); //set column field database for datatable orderable
    var $column_search_pompa = array('id_pompa','nama_pompa'); //set column field database for datatable searchable
    var $order_pompa = array('id_master_pompa' => 'asc');


    //fungsi untuk cancel order
    public function cancelOrder($data){
        $this->db->set('soft_delete', 1 );
        $this->db->where('id_transaksi',$data['id']);
        $this->db->update('transaksi_tenant');

        if($this->db->affected_rows() > 0){
            $result = $this->get_by_id("tenant",$data['id']);
            $this->db->set('status_tagihan', 0);
            $this->db->where('id_realisasi',$result->id_ref_realisasi);
            $this->db->update('realisasi_tenant');

            return TRUE;
        }

    }

    public function cancelRealisasi($data){
        $this->db->set('soft_delete', 1 );
        $this->db->where('id_realisasi',$data['id']);
        $this->db->update('realisasi_tenant');

        if($this->db->affected_rows() > 0)
            return TRUE;

    }

    public function getDataTenant($id){
        $query = $this->db->select('*')
            ->from('master_tenant')
            ->where('id_ref_flowmeter',$id)
            ->get();

        return $query->row();
    }

    //fungsi database untuk master data pompa
    public function edit_master_pompa($data){
        $this->db->set('id_pompa',$data['id_pompa']);
        $this->db->set('nama_pompa',$data['nama_pompa']);
        $this->db->set('kondisi',$data['kondisi']);
        $this->db->set('flowmeter',$data['flowmeter']);
        $this->db->where('id_master_pompa',$data['id_master_pompa']);
        $query = $this->db->update('master_pompa');

        return $query->affected_rows();
    }

    public function getIdFlowmeter($id = ''){
        $this->db->from('master_flowmeter');
        if($id != ''){
            $this->db->where('id_flow',$id);
        }
        $query = $this->db->get();

        if($id != '')
            return $query->row();
        else
            return $query->result();
    }

    public function getNamaPompa($id){
        $this->db->from('master_flowmeter,master_pompa');
        $this->db->where('id_flow',$id);
        $this->db->where('id_ref_pompa = id_master_pompa');
        $query = $this->db->get();

        return $query->row();
    }

    public function get_datatables_pompa() {
        $this->_get_datatables_query_pompa();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query_pompa() {

        $this->db->from("master_pompa");
        $this->db->where('soft_delete','0');

        $i = 0;

        foreach ($this->column_search_pompa as $item) // loop column
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

                if(count($this->column_search_pompa) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_pompa[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_pompa))
        {
            $order = $this->order_pompa;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_filtered_pompa(){
        $this->_get_datatables_query_pompa();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_pompa(){
        $this->db->from("master_pompa");
        $this->db->where('soft_delete','0');
        return $this->db->count_all_results();
    }

    public function getPompa(){
        $this->db->from('master_pompa');
        $this->db->where('status_aktif',1);
        $query = $this->db->get();

        return $query->result();
    }

    //fungsi database untuk master data sumur
    public function edit_master_sumur($data){
        $this->db->set('id_sumur',$data['id_sumur']);
        $this->db->set('nama_sumur',$data['nama_flowmeter']);
        $this->db->set('lokasi',$data['lokasi']);
        $query = $this->db->update('master_sumur');

        return $query->affected_rows();
    }

    public function get_datatables_sumur()
    {
        $this->_get_datatables_query_sumur();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query_sumur()
    {

        $this->db->from("master_sumur");
        $this->db->where('soft_delete','0');

        $i = 0;

        foreach ($this->column_search_sumur as $item) // loop column
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

                if(count($this->column_search_sumur) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_sumur[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_sumur))
        {
            $order = $this->order_sumur;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_filtered_sumur()
    {
        $this->_get_datatables_query_sumur();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_sumur()
    {
        $this->db->from("master_sumur");
        $this->db->where('soft_delete','0');
        return $this->db->count_all_results();
    }

    public function getNamaSumur($id){
        $this->db->from('master_sumur');
        $this->db->where('id_master_sumur',$id);
        $this->db->where('soft_delete','0');
        $query = $this->db->get();

        return $query->row();
    }

    public function getIDSumur(){
        $this->db->from('master_sumur');
        $this->db->where('status_aktif',1);
        $this->db->where('soft_delete','0');
        $query = $this->db->get();

        return $query->result();
    }

    //fungsi database untuk master data flowmeter
    public function edit_master_flowmeter($data){
        $this->db->set('id_flowmeter',$data['id_flowmeter']);
        $this->db->set('nama_flowmeter',$data['nama_flowmeter']);
        $this->db->set('kondisi',$data['kondisi']);
        $this->db->set('flowmeter_awal',$data['flowmeter_awal']);
        $this->db->set('flowmeter_akhir',$data['flowmeter_akhir']);
        $this->db->set('status_aktif',$data['status_aktif']);
        $this->db->set('kondisi',$data['kondisi']);
        $this->db->set('id_ref_pompa',$data['id_ref_poma']);
        $this->db->where('id_flow',$data['id_master_flowmeter']);
        $query = $this->db->update('master_flowmeter');

        return $query->affected_rows();
    }

    public function get_datatables_flowmeter()
    {
        $this->_get_datatables_query_flowmeter();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query_flowmeter()
    {
        $this->db->from("master_flowmeter");
        $this->db->where('soft_delete','0');

        $i = 0;

        foreach ($this->column_search_flowmeter as $item) // loop column
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

                if(count($this->column_search_flowmeter) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->where('id_flow >','0');
            $this->db->order_by($this->column_order_flowmeter[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_flowmeter))
        {
            $order = $this->order_flowmeter;
            $this->db->where('id_flow >','0');
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_filtered_flowmeter()
    {
        $this->_get_datatables_query_flowmeter();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_flowmeter()
    {
        $this->db->from("master_flowmeter");
        $this->db->where('soft_delete','0');
        return $this->db->count_all_results();
    }

    public function getKondisi(){
        $this->db->from('master_flowmeter');
        $this->db->where('soft_delete','0');
        $query = $this->db->get();

        return $query->result();
    }

    public function cekFlowAwal($id){
        $this->db->from('master_flowmeter');
        $this->db->where('soft_delete','0');
        $this->db->where('id_flow',$id);
        $query = $this->db->get();

        if($query->row()->flowmeter_awal == 0 && $query->row()->flowmeter_awal != NULL)
            return TRUE;
    }

    public function inputFlowAwal($data){
        $this->db->set('flowmeter_awal',$data['flowmeter_awal']);
        $this->db->where('id_flow',$data['id_flow']);
        $this->db->update('master_flowmeter');

        return $this->db->affected_rows();
    }

    public function getFlowmeter(){
        $this->db->from('master_flowmeter');
        $this->db->where('status_aktif',1);
        $this->db->where('soft_delete','0');
        $this->db->order_by('id_flowmeter','ASC');
        $query = $this->db->get();

        return $query->result();
    }

    public function getDataFlowmeter($tgl_awal = '',$tgl_akhir = '',$id_flow){
        $this->db->from('master_flowmeter');
        $this->db->join('pencatatan_flow','id_ref_flowmeter = id_flow','left');
        $this->db->where('id_flow', $id_flow);
        $this->db->where('waktu_perekaman BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:00:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:59")).'"');
        $this->db->where('status_aktif',1);
        $this->db->order_by('id_flowmeter','ASC');
        $query = $this->db->get();

        return $query->row();
    }

    public function setFlowAkhir($data){
        $this->db->set('flowmeter_akhir',$data['flow']);
        $this->db->where('id_flow',$data['id']);
        $this->db->update("master_flowmeter");

        return $this->db->affected_rows();
    }

    //fungsi database untuk master data tenant
    public function edit_master_tenant($data){
        $this->db->set('flow_awal',$data['flowmeter_awal']);
        $this->db->where('id_flowmeter',$data['id_flowmeter']);
        $query = $this->db->update('master_flowmeter');

        return $query;
    }

    public function get_datatables_tenant(){
        $this->_get_datatables_query_tenant();
        if($_POST['length'] != -1){
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query_tenant(){

        $this->db->from("master_tenant");
        $this->db->join('master_flowmeter','id_ref_flowmeter = id_flow','left');
        $this->db->where('master_tenant.soft_delete','0');

        $i = 0;

        foreach ($this->column_search_tenant as $item) // loop column
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

                if(count($this->column_search_tenant) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_tenant[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order_tenant))
        {
            $order = $this->order_tenant;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_filtered_tenant(){
        $this->_get_datatables_query_tenant();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_tenant(){
        $this->db->from("master_tenant");
        $this->db->where('soft_delete','0');
        return $this->db->count_all_results();
    }

    public function getIDTenant(){
        $this->db->from('master_tenant');
        $this->db->where('soft_delete','0');
        $query = $this->db->get();

        return $query->result();
    }

    public function getTenant($id){
        $this->db->from('master_tenant');
        $this->db->where('id_tenant',$id);
        $query = $this->db->get();

        return $query->row();
    }

    //fungsi database untuk delete data master pada ruko,darat dan laut
    public function delete_data($tipe,$id){
        if($tipe == "tenant"){
            $this->db->set('soft_delete','1');
            $this->db->where('id_tenant', $id);
            $this->db->update('master_tenant');
            //$this->db->delete("master_tenant");
        }else{
            $this->db->set('soft_delete','1');
            $this->db->where('id_flowmeter', $id);
            $this->db->update('master_flowmeter');
            //$this->db->delete("master_flowmeter");
        }
    }

    function getFlow($tgl_awal = '',$tgl_akhir = '',$id){
        $this->db->select('*');
        $this->db->from('pencatatan_flow');
        $this->db->where('waktu_perekaman BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:00:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:59")).'"');
        $this->db->where('status_perekaman',1);
        $this->db->where('id_ref_flowmeter =',$id);
        $this->db->order_by('flow_hari_ini', 'ASC');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    function getSumur($tgl_awal = '',$tgl_akhir = '',$id){
        $this->db->select('*');
        $this->db->from('pencatatan_sumur');
        //$this->db->join('master_flowmeter','id_ref_flowmeter = id_flow','left');
        //$this->db->join('master_pompa','id_ref_pompa = id_master_pompa','left');
        //$this->db->join('master_sumur','id_ref_sumur = id_master_sumur','left');
        $this->db->where('waktu_perekaman BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
        $this->db->where('id_ref_flowmeter',$id);
        $this->db->where('status_pencatatan',1);
        $this->db->order_by('waktu_perekaman', 'ASC');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row();
        } else{
            return false;
        }
    }

    function getIssuer($id){
        $this->db->from('pencatatan_sumur');
        $this->db->where('id_pencatatan',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row();
        } else{
            return false;
        }
    }

    function riwayat_flow($tgl_awal = '',$tgl_akhir = ''){
        $this->db->select('id_flow,id_flowmeter,nama_flowmeter,flow_hari_ini,waktu_perekaman,id_transaksi,pencatatan_flow.issued_by as pembuat');
        $this->db->from('pencatatan_flow,master_flowmeter');
        $this->db->where('status_perekaman',NULL);
        //$this->db->where('waktu_perekaman BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:00:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:59")).'"');
        $this->db->where('id_ref_flowmeter = id_flow');

        $query = $this->db->get();
        return $query;
    }

    function riwayat_tandon($tgl_awal = '',$tgl_akhir = ''){
        $this->db->from('vw_transaksi_tandon');
        $this->db->where('status_pencatatan',NULL);
        $query = $this->db->get();
        return $query;
    }

    function riwayat_sumur($tgl_awal = '',$tgl_akhir = ''){
        $this->db->select('id_flow,id_master_sumur,id_sumur,nama_pompa,nama_flowmeter,nama_sumur,cuaca_awal,cuaca_akhir,debit_air_awal,debit_air_akhir,
        flow_sumur_awal,flow_sumur_akhir,waktu_rekam_awal,waktu_rekam_akhir,id_pencatatan,pencatatan_sumur.issued_by as pembuat');
        $this->db->from('pencatatan_sumur,master_sumur,master_pompa,master_flowmeter');
        $this->db->where('status_pencatatan',NULL);
        //$this->db->where('waktu_perekaman BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
        $this->db->where('id_ref_flowmeter = id_flow');
        $this->db->where('id_ref_pompa = id_master_pompa');
        $this->db->where('id_ref_sumur = id_master_sumur');

        $query = $this->db->get();

        return $query;
    }

    function tagihanTenant($data){
        $data_tagihan = array(
            'tgl_transaksi' => date('Y-m-d H:i:s',time()),
            'tgl_awal' => $data['tgl_awal'],
            'tgl_akhir' => $data['tgl_akhir'],
            'id_ref_flowmeter' => $data['id'],
            'total_pakai' => $data['total_pakai'],
            'tarif' => $data['tarif'],
            'diskon' => $data['diskon'],
            'total_bayar' => $data['total_bayar'],
            'no_invoice' => $data['no_invoice'],
            'issued_by' => '',
            'issued_at' => '',
        );

        $query = $this->db->insert("transaksi_tenant",$data_tagihan);

        return $query;
    }

    function realisasiTagihanTenant($data){
        $data_realisasi = array(
            'tgl_transaksi' => date('Y-m-d H:i:s',time()),
            'tgl_awal' => $data['tgl_awal'],
            'tgl_akhir' => $data['tgl_akhir'],
            'id_ref_flowmeter' => $data['id'],
            'flow_awal' => $data['flow_awal'],
            'flow_akhir' => $data['flow_akhir'],
            'issued_by' => $data['issued_by'],
            'issued_at' => $data['issued_at'],
        );

        $query = $this->db->insert("realisasi_tenant",$data_realisasi);

        return $query;
    }

    function getDetailTagihan($id){
        $this->db->select('*');
        $this->db->from('transaksi_tenant');
        $this->db->where('id_ref_flowmeter =',$id);
        $this->db->where('soft_delete = 0');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return false;
        }
    }

    function getDataTagihan($tgl_awal = '',$tgl_akhir = '',$id){
        $this->db->select('*');
        $this->db->from('master_tenant');
        $this->db->join('master_flowmeter','master_tenant.id_ref_flowmeter = id_flow','left');
        //$this->db->join('transaksi_tenant','transaksi_tenant.id_ref_flowmeter = id_flow','left');
        $this->db->join('pencatatan_flow','pencatatan_flow.id_ref_flowmeter = id_flow','left');
        $this->db->join('pengguna_jasa','pengguna_jasa_id = id_tarif','left');
        $this->db->join('master_lumpsum','id_ref_tenant = id_tenant','left');
        $this->db->where('waktu_perekaman BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:00:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:59")).'"');
        $this->db->where('status_perekaman',1);
        $this->db->where('master_tenant.id_ref_flowmeter =',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return false;
        }
    }

    function getDataRealisasi($tgl_awal = '',$tgl_akhir = '',$id){
        $this->db->select('*');
        $this->db->from('realisasi_tenant');
        $this->db->where('tgl_awal',$tgl_awal);
        $this->db->where('tgl_akhir',$tgl_akhir);
        $this->db->where('id_realisasi',$id);
        $this->db->where('soft_delete','0');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return false;
        }
    }

    function getTagihan($tgl_awal = '',$tgl_akhir = '',$id){
        $this->db->select('*');
        $this->db->from('master_tenant');
        $this->db->join('master_flowmeter','master_tenant.id_ref_flowmeter = id_flow','left');
        //$this->db->join('transaksi_tenant','transaksi_tenant.id_ref_flowmeter = id_flow','left');
        $this->db->join('pencatatan_flow','pencatatan_flow.id_ref_flowmeter = id_flow','left');
        $this->db->join('pengguna_jasa','pengguna_jasa_id = id_tarif','left');
        $this->db->join('master_lumpsum','id_ref_tenant = id_tenant','left');
        $this->db->where('waktu_perekaman BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:00:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:59")).'"');
        $this->db->where('status_perekaman',1);
        $this->db->where('master_tenant.id_ref_flowmeter =',$id);
        $this->db->order_by('waktu_perekaman', 'ASC');
        $this->db->group_by('pencatatan_flow.id_transaksi');
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return false;
        }
    }

    function cekRealisasi($tgl_awal = '',$tgl_akhir = '',$id){
        $this->db->select('*');
        $this->db->from('realisasi_tenant');
        $this->db->where('tgl_awal',date('Y-m-d', strtotime($tgl_awal)));
        $this->db->where('tgl_akhir',date('Y-m-d', strtotime($tgl_akhir)));
        $this->db->where('status_tagihan',0);
        $this->db->where('id_ref_flowmeter =',$id);
        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return NULL;
        }
    }

    function setStatusTagihan($id,$status){
        $this->db->set('status_tagihan',$status);
        $this->db->where('id_realisasi',$id);
        $this->db->update('realisasi_tenant');

        if($this->db->affected_rows() > 0)
            return TRUE;
        else
            return FALSE;
    }

    public function setPencatatan($tipe){
        $data = $this->input->post('cek');
        $flow = $this->input->post('flow');
        $id = $this->input->post('id');
        $jumlah = count($data);

        if($tipe == 'batal'){
            for($i=0;$i<$jumlah;$i++){
                $this->db->set('status_pencatatan',0);
                $this->db->where('id_pencatatan',$data[$i]);
                $this->db->update('pencatatan_sumur');
            }
        } else{
            for($i=0;$i<$jumlah;$i++){
                $this->db->set('status_pencatatan',1);
                $this->db->where('id_pencatatan',$data[$i]);
                $this->db->update('pencatatan_sumur');

                $this->db->set('flowmeter_akhir',$flow[$i]);
                $this->db->where('id_flow', $id[$i]);
                $this->db->update('master_flowmeter');
            }
        }

        return $this->db->affected_rows();
    }

    public function setPencatatanTandon($tipe){
        $data = $this->input->post('cek');
        $id = $this->input->post('id');
        $jumlah = count($data);

        if($tipe == 'batal'){
            for($i=0;$i<$jumlah;$i++){
                $this->db->set('status_pencatatan',0);
                $this->db->where('id_transaksi',$data[$i]);
                $this->db->update('transaksi_tandon');
            }
        } else{
            for($i=0;$i<$jumlah;$i++){
                $this->db->set('status_pencatatan',1);
                $this->db->where('id_transaksi',$data[$i]);
                $this->db->update('transaksi_tandon');
            }
        }

        return $this->db->affected_rows();
    }

    public function setPerekaman($tipe){
        $data = $this->input->post('cek');
        $flow = $this->input->post('flow');
        $id = $this->input->post('id');
        $jumlah = count($data);

        if($tipe == 'batal'){
            for($i=0;$i<$jumlah;$i++){
                $this->db->set('status_perekaman',0);
                $this->db->where('id_transaksi',$data[$i]);
                $this->db->update('pencatatan_flow');
            }
        } else{
            for($i=0;$i<$jumlah;$i++){
                $this->db->set('status_perekaman',1);
                $this->db->where('id_transaksi',$data[$i]);
                $this->db->update('pencatatan_flow');

                $this->db->set('flowmeter_akhir',$flow[$i]);
                $this->db->where('id_flow', $id[$i]);
                $this->db->update('master_flowmeter');
            }
        }

        return $this->db->affected_rows();
    }

    public function update_pembayaran_tenant($where, $data){
        $this->db->insert('realisasi_transaksi_tenant',$data);

        $this->db->set('status_invoice', 0);
        $this->db->where('id_transaksi',$where);
        $this->db->update("transaksi_tenant");

        return $this->db->affected_rows();
    }

    public function update_status_pembayaran_tenant($where){
        $this->db->set('status_pembayaran', 1);
        $this->db->where('id_realisasi',$where);
        $this->db->update("realisasi_tenant");

        return $this->db->affected_rows();
    }

    public function get_by_id($tipe,$id) {
        if($tipe == "ruko"){
            $this->db->from('master_tenant');
            $this->db->join('master_flowmeter','id_ref_flowmeter = id_flow','left');
            $this->db->join('master_lumpsum','id_ref_tenant = id_tenant','left');
            $this->db->where('id_flow',$id);
        }
        else{
            $this->db->from('transaksi_tenant');
            $this->db->join('master_flowmeter','transaksi_tenant.id_ref_flowmeter = id_flow','left');
            $this->db->join('master_tenant','master_tenant.id_ref_flowmeter = id_flow','left');
            $this->db->where('id_transaksi',$id);
        }

        $query = $this->db->get();
        return $query->row();
    }

    public function get_num_tabel_transaksi($tipe){
        $this->db->select('*');
        $this->db->from('transaksi_tenant');
        $this->db->join('master_flowmeter','transaksi_tenant.id_ref_flowmeter = id_flow','left');
        $this->db->join('master_tenant','master_tenant.id_ref_flowmeter = id_flow','left');
        $this->db->join('pengguna_jasa','pengguna_jasa_id = id_tarif','left');
        $this->db->join('master_lumpsum','id_ref_tenant = id_tenant','left');
        $this->db->where('transaksi_tenant.soft_delete','0');
        $this->db->order_by('nama_tenant','ASC');
        $this->db->group_by('transaksi_tenant.id_transaksi');

        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->num_rows();
        }
    }

    public function get_tabel_transaksi($config = ''){
        $this->db->select('*');
        $this->db->from('transaksi_tenant');
        $this->db->join('master_flowmeter','transaksi_tenant.id_ref_flowmeter = id_flow','left');
        $this->db->join('master_tenant','master_tenant.id_ref_flowmeter = id_flow','left');
        $this->db->join('pengguna_jasa','pengguna_jasa_id = id_tarif','left');
        $this->db->join('master_lumpsum','id_ref_tenant = id_tenant','left');
        $this->db->where('transaksi_tenant.soft_delete','0');
        $this->db->order_by('id_transaksi','DESC');
        $this->db->group_by('transaksi_tenant.id_transaksi');

        if($config != NULL)
            $query = $this->db->get('',$config['per_page'], $this->uri->segment(3));
        else
            $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function get_tabel_realisasi($config = ''){
        $this->db->select('*');
        $this->db->from('realisasi_tenant');
        $this->db->join('master_flowmeter','realisasi_tenant.id_ref_flowmeter = id_flow','left');
        $this->db->join('master_tenant','master_tenant.id_ref_flowmeter = id_flow','left');
        $this->db->join('master_lumpsum','id_ref_tenant = id_tenant','left');
        $this->db->where('realisasi_tenant.soft_delete','0');
        $this->db->order_by('id_realisasi','DESC');
        $this->db->group_by('realisasi_tenant.id_realisasi');

        if($config != NULL)
            $query = $this->db->get('',$config['per_page'], $this->uri->segment(3));
        else
            $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function input_transaksi($tipe,$data){
        if($tipe == "ruko"){
            $insert_data = array(
                'id_ref_flowmeter' => $data['id_flow'],
                'waktu_perekaman' => $data['waktu_perekaman'],
                'flow_hari_ini' => $data['flow_hari_ini'],
                'issued_at' => $data['issued_at'],
                'issued_by' => $data['issued_by'],
            );
            $query = $this->db->insert($this->tabel_transaksi_ruko, $insert_data);
        } else if($tipe == "tandon"){
            $query = $this->db->insert('transaksi_tandon', $data);
        } else {
            $query = $this->db->insert('pencatatan_sumur', $data);
        } 

        if($query){
            return TRUE;
        }
    }

    //function untuk manajemen data transaksi pada aplikasi
    public function get_pembeli($tipe, $nama){
        if($tipe == "ruko"){
            $this->db->like('id_flowmeter', $nama);
            $this->db->or_like('nama_flowmeter', $nama);
            $this->db->where('id_flow !=',0);
            $this->db->where('status_aktif',1);
            $this->db->where('master_flowmeter.soft_delete','0');
            $this->db->from('master_flowmeter');
            $this->db->order_by('id_flowmeter','ASC');
        }
        else if($tipe == "ruko_tagihan"){
            $this->db->like('nama_tenant', $nama);
            $this->db->or_like('id_flowmeter', $nama);
            $this->db->or_like('nama_flowmeter', $nama);
            $this->db->from('master_tenant');
            $this->db->join('master_flowmeter','id_flow = id_ref_flowmeter','left');
            $this->db->where('master_tenant.soft_delete','0');
            $this->db->where('master_tenant.status_aktif_tenant','1');
        }
        else{
            $this->db->like('id_flowmeter', $nama);
            $this->db->or_like('nama_flowmeter', $nama);
            $this->db->from('master_flowmeter');
            $this->db->join('master_pompa','id_ref_pompa = id_master_pompa','left');
            $this->db->join('master_sumur','id_ref_sumur = id_master_sumur','left');
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) { //jika ada maka jalankan
            return $query->result();
        }
    }

    public function get_tandon($nama){
        $this->db->like('nama_tandon', $nama);
        $this->db->where('soft_delete',0);
        $this->db->from('master_tandon');
        $this->db->order_by('id','ASC');

        $query = $this->db->get();

        if ($query->num_rows() > 0) { //jika ada maka jalankan
            return $query->result();
        }
    }

}

?>