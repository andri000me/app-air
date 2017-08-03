<?php
    class Data extends CI_Model {
        var $tabel_darat            = 'pembeli_darat';
        var $tabel_laut             = 'pembeli_laut';
        var $tabel_pengguna         = 'pengguna_jasa';
        var $tabel_transaksi_darat  = 'transaksi_darat';
        var $tabel_transaksi_ruko   = 'transaksi_tenant';
        var $tabel_transaksi_laut   = 'transaksi_laut';

        var $table = 'users';
        var $column_order = array(null,'username', 'role',null); //set column field database for datatable orderable
        var $column_search = array('username'); //set column field database for datatable searchable just firstname , lastname , address are searchable
        var $order = array('id_user' => 'asc'); // default order

        var $column_order_ruko = array(null, 'id_flowmeter','nama_pengguna_jasa', null); //set column field database for datatable orderable
        var $column_search_ruko = array('id_flowmeter','nama_pengguna_jasa'); //set column field database for datatable searchable
        var $order_ruko = array('id_flowmeter' => 'desc');

        var $column_order_darat = array(null, 'id_pengguna_jasa','nama_pengguna_jasa',null,null, null); //set column field database for datatable orderable
        var $column_search_darat = array('id_pengguna_jasa','nama_pengguna_jasa'); //set column field database for datatable searchable
        var $order_darat = array('id_pengguna_jasa' => 'desc');

        var $column_order_laut = array(null, 'id_pengguna_jasa','nama_lct',null,null, null,null,null, null); //set column field database for datatable orderable
        var $column_search_laut = array('id_pengguna_jasa','id_lct','nama_lct'); //set column field database for datatable searchable
        var $order_laut = array('id_pengguna_jasa' => 'desc');

        var $column_order_tarif = array(null,'tipe_pengguna_jasa',null,null, null,null); //set column field database for datatable orderable
        var $column_search_tarif = array('tipe_pengguna_jasa'); //set column field database for datatable searchable
        var $order_tarif = array('id_tarif' => 'desc');

        var $column_order_agent = array(null,'nama_perusahaan',null,null); //set column field database for datatable orderable
        var $column_search_agent = array('nama_perusahaan'); //set column field database for datatable searchable
        var $order_agent = array('id_agent' => 'desc');

        var $column_order_tenant = array(null,'nama_tenant',null,null,null,null,null,null); //set column field database for datatable orderable
        var $column_search_tenant = array('nama_tenant','penanggung_jawab'); //set column field database for datatable searchable
        var $order_tenant = array('id_tenant' => 'desc');

        var $column_order_flowmeter = array(null,'id_flowmeter','nama_flowmeter',null,null,null,null); //set column field database for datatable orderable
        var $column_search_flowmeter = array('id_flowmeter','nama_flowmeter'); //set column field database for datatable searchable
        var $order_flowmeter = array('id_flow' => 'asc');

        var $column_order_sumur = array(null,'id_sumur','nama_sumur',null,null,null,null); //set column field database for datatable orderable
        var $column_search_sumur = array('id_sumur','nama_sumur'); //set column field database for datatable searchable
        var $order_sumur = array('id_master_sumur' => 'asc');

        var $column_order_pompa = array(null,'id_pompa','nama_pompa',null,null,null,null); //set column field database for datatable orderable
        var $column_search_pompa = array('id_pompa','nama_pompa'); //set column field database for datatable searchable
        var $order_pompa = array('id_master_pompa' => 'asc');

        var $column_order_lumpsum = array(null,'no_perjanjian','nama_perjanjian',null,null); //set column field database for datatable orderable
        var $column_search_lumpsum = array('no_perjanjian','nama_perjanjian'); //set column field database for datatable searchable
        var $order_lumpsum = array('id_lumpsum' => 'asc');

        function __construct() {
            parent::__construct();
        }

        //function untuk manajemen data transaksi pada aplikasi
        public function get_pembeli($tipe, $nama){
            if($tipe == "darat"){
                $tabel = $this->tabel_darat;
                $this->db->like('nama_pengguna_jasa', $nama);
                $this->db->from($tabel);
                $this->db->where('pengguna_jasa_id_tarif !=','1');
            }else if($tipe == "darat_perusahaan"){
                $tabel = $this->tabel_darat;
                $this->db->like('nama_pengguna_jasa', $nama);
                $this->db->from($tabel);
                $this->db->where('pengguna_jasa_id_tarif !=','1');
                $this->db->where('pengguna_jasa_id_tarif !=','2');
                $this->db->where('pengguna_jasa_id_tarif !=','3');
            } else if($tipe == "ruko"){
                $this->db->like('id_flow', $nama);
                $this->db->where('id_flow !=',0);
                $this->db->from('master_flowmeter');
            } else if($tipe == "ruko_tagihan"){
                $this->db->like('id_tenant', $nama);
                $this->db->from('master_tenant,master_flowmeter');
                $this->db->where('id_flow = id_master_flowmeter');
            } else if($tipe == "agent"){
                $this->db->like('nama_perusahaan', $nama);
                $this->db->from('master_agent');
            } else{
                $this->db->like('nama_lct', $nama);
                $this->db->from('pembeli_laut,master_agent');
                $this->db->where('id_agent = id_agent_master');
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0) { //jika ada maka jalankan
                 return $query->result();
            }
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

        public function getIDPengguna($nama){
            $this->db->from('pembeli_darat');
            $this->db->where('nama_pengguna_jasa',$nama);
            $query = $this->db->get();

            return $query->row();
        }

        public function input_transaksi($tipe,$data){
            if($tipe == "darat"){
                $query = $this->db->insert($this->tabel_transaksi_darat,$data);
            }else if($tipe == "ruko"){
                $insert_data = array(
                    'flowmeter_tenant' => $data['id_flow'],
                    'waktu_perekaman' => $data['waktu_perekaman'],
                    'flow_hari_ini' => $data['flow_hari_ini'],
                    'issued_at' => $data['issued_at'],
                    'issued_by' => $data['issued_by'],
                );
                $query = $this->db->insert($this->tabel_transaksi_ruko, $insert_data);

                $this->db->set('flowmeter_akhir',$data['flow_hari_ini']);
                $this->db->where('id_flow',$data['id_flow']);
                $this->db->update("master_flowmeter");
            }else{
                $query = $this->db->insert($this->tabel_transaksi_laut,$data);
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
                $this->db->where('nama_lct',$nama);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0) { //jika ada maka jalankan
                return TRUE;
            }else{
                return FALSE;
            }

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

        public function get_tabel_transaksi($tipe){
            if($tipe == "darat"){
                $this->db->select('*');
                $this->db->from('transaksi_darat ,pembeli_darat,pengguna_jasa');
                $this->db->where('pengguna_jasa_id_tarif !=','1');
                $this->db->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa');
                $this->db->where('pengguna_jasa_id_tarif = id_tarif');
                $this->db->where('soft_delete = 0');
                $this->db->order_by('tgl_transaksi', 'DESC');
            }else if($tipe == "ruko"){
                $this->db->select('*');
                $this->db->from('master_flowmeter ,pembeli_darat,pengguna_jasa');
                $this->db->where('pengguna_jasa_id_tarif =','1');
                $this->db->where('id_flowmeter = master_flowmeter_id_flowmaster');
                $this->db->where('pengguna_jasa_id_tarif = id_tarif');
            }else{
                $this->db->select('*');
                $this->db->from('transaksi_laut ,pembeli_laut,pengguna_jasa,master_agent');
                $this->db->where('pembeli_laut_id_pengguna_jasa = id_pengguna_jasa');
                $this->db->where('pengguna_jasa_id_tarif = id_tarif');
                $this->db->where('id_agent = id_agent_master');
                $this->db->order_by('tgl_transaksi', 'DESC');
                $this->db->where('soft_delete = 0');
            }

            $query = $this->db->get();

            if($query->num_rows() > 0){
                return $query->result();
            }
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

        public function get_no_pengguna($id){
            $query = $this->db->select('pengguna_jasa_id_tarif')
                        ->from($this->tabel_darat)
                        ->where('id_pengguna_jasa',$id)
                        ->get();
            $result = $query->result_array();
            $data = array_shift($result);
            return $data['pengguna_jasa_id_tarif'];
        }

        public function get_data_kwitansi($id){
            $this->db->from('transaksi_darat');
            $this->db->where('no_kwitansi ', $id);
            $this->db->where('soft_delete ', 0);
            $query = $this->db->get();
            $result = $query->row();

            if($result->status_pembayaran == 0 ){
                return TRUE;
            } else{
                return FALSE;
            }
        }

        public function get_by_id($tipe,$id) {
            if($tipe == "darat"){
                $this->db->from('transaksi_darat ,pembeli_darat,pengguna_jasa');
                $this->db->where('id_transaksi',$id);
                $this->db->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa');
                $this->db->where('pengguna_jasa_id_tarif = id_tarif');
            }
            else if($tipe == "ruko"){
                $this->db->from('master_tenant,master_flowmeter');
                $this->db->where('id_master_flowmeter = id_flow');
                $this->db->where('id_flow',$id);
            }
            else if($tipe == "laut_realisasi"){
                $this->db->from('transaksi_laut ,pembeli_laut,pengguna_jasa,master_agent');
                $this->db->where('id_transaksi',$id);
                $this->db->where('pembeli_laut_id_pengguna_jasa = id_pengguna_jasa');
                $this->db->where('id_agent = id_agent_master');
                $this->db->where('pengguna_jasa_id_tarif = id_tarif');
            }
            else{
                $null = NULL;
                $this->db->from('transaksi_laut ,pembeli_laut');
                $this->db->where('id_transaksi',$id);
                $this->db->where('flowmeter_awal !=',$null);
                $this->db->where('flowmeter_akhir !=',$null);
                $this->db->where('pembeli_laut_id_pengguna_jasa = id_pengguna_jasa');
            }

            $query = $this->db->get();
            return $query->row();
        }

        public function update_realisasi($tipe,$where, $data){
            if($tipe == "darat"){
                $this->db->update($this->tabel_transaksi_darat, $data, $where);
            }else if($tipe == "ruko"){

            }else{
                $this->db->update($this->tabel_transaksi_laut, $data, $where);
            }
            return $this->db->affected_rows();
        }

        public function update_pembayaran($where, $data){
            $this->db->insert('realisasi_transaksi_laut',$data);

            $this->db->set('realisasi_transaksi_laut_id_realisasi', $where);
            $this->db->where('id_transaksi',$where);
            $this->db->update($this->tabel_transaksi_laut);

            return $this->db->affected_rows();
        }

        public function update_pembayaran_darat($where, $data){
            $this->db->insert('realisasi_transaksi_darat',$data);

            $this->db->set('realisasi_transaksi_darat_id_realisasi', $where);
            $this->db->set('status_invoice', 0);
            $this->db->set('status_pembayaran', 1);
            $this->db->where('id_transaksi',$where);
            $this->db->update($this->tabel_transaksi_darat);

            return $this->db->affected_rows();
        }

        public function ubah_waktu_pengantaran($data){
            $this->db->set('waktu_mulai_pengantaran',$data['waktu']);
            $this->db->set('last_modified',$data['waktu']);
            $this->db->set('modified_by',$data['user']);
            $this->db->set('pengantar',$data['user']);
            $this->db->where('id_transaksi',$data['id']);
            $this->db->update('transaksi_darat');

            return $this->db->affected_rows();
        }

        //fungsi database untuk pembuatan laporan, kwitansi dan tagihan
        public function cetakKwitansi($tipe ,$id){
            if($tipe == "darat"){
                $query = $this->db->select('*')
                    ->from('transaksi_darat,pengguna_jasa,pembeli_darat')
                    ->where('id_transaksi', $id)
                    ->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa')
                    ->where('pengguna_jasa_id_tarif = id_tarif')
                    ->get();
            }
            else if($tipe == "ruko"){

            }
            else {
                $query = $this->db->select('*')
                    ->from('transaksi_laut,pengguna_jasa,pembeli_laut,master_agent')
                    ->where('id_transaksi', $id)
                    ->where('pembeli_laut_id_pengguna_jasa = id_pengguna_jasa')
                    ->where('pengguna_jasa_id_tarif = id_tarif')
                    ->where('id_agent = id_agent_master')
                    ->get();
            }

            return $query->row();
        }

        function getTagihan($tgl_awal,$tgl_akhir,$id){
            $this->db->select('*');
            $this->db->from('transaksi_tenant , master_tenant ,pengguna_jasa,master_flowmeter,master_lumpsum');
            $this->db->where('waktu_perekaman BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
            $this->db->where('id_master_flowmeter = id_flow');
            $this->db->where('flowmeter_tenant = id_flow');
            $this->db->where('id_master_lumpsum = id_lumpsum');
            $this->db->where('pengguna_jasa_id = id_tarif');
            $this->db->where('id_flow =',$id);
            $this->db->order_by('flow_hari_ini', 'ASC');
            $query = $this->db->get();

            if($query->num_rows() > 0){
                return $query->result();
            }else{
                return false;
            }
        }

        function getDataTagihan($tgl_awal,$tgl_akhir,$id){
            $this->db->select('*');
            $this->db->from('transaksi_tenant , master_tenant ,pengguna_jasa,master_flowmeter,master_lumpsum');
            $this->db->where('waktu_perekaman BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
            $this->db->where('id_master_flowmeter = id_flow');
            $this->db->where('flowmeter_tenant = id_flow');
            $this->db->where('id_master_lumpsum = id_lumpsum');
            $this->db->where('pengguna_jasa_id = id_tarif');
            $this->db->where('id_flow =',$id);
            $query = $this->db->get();

            if($query->num_rows() > 0){
                return $query->row();
            }else{
                return false;
            }
        }

        function getDataLaporan($tgl_awal,$tgl_akhir, $tipe){
            if($tipe == "darat"){
                $this->db->select('*');
                $this->db->from('transaksi_darat , pembeli_darat ,pengguna_jasa');
                $this->db->where('tgl_transaksi BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
                $this->db->where('pengguna_jasa_id_tarif !=','1');
                $this->db->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa');
                $this->db->where('pengguna_jasa_id_tarif = id_tarif');
                $this->db->where('soft_delete =',0);
                $this->db->order_by('tgl_transaksi','ASC');
            }else if($tipe == "laut"){
                $this->db->select('*');
                $this->db->from('transaksi_laut , pembeli_laut ,pengguna_jasa,master_agent,realisasi_transaksi_laut');
                $this->db->where('tgl_transaksi BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
                $this->db->where('pembeli_laut_id_pengguna_jasa = id_pengguna_jasa');
                $this->db->where('pengguna_jasa_id_tarif = id_tarif');
                $this->db->where('id_agent = id_agent_master');
                $this->db->where('realisasi_transaksi_laut_id_realisasi = id_realisasi');
                $this->db->where('soft_delete =',0);
                $this->db->order_by('tgl_transaksi','ASC');
            } else if($tipe == "laut_operasi"){
                $this->db->select('*');
                $this->db->from('transaksi_laut , pembeli_laut ,pengguna_jasa,master_agent');
                $this->db->where('tgl_transaksi BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
                $this->db->where('pembeli_laut_id_pengguna_jasa = id_pengguna_jasa');
                $this->db->where('pengguna_jasa_id_tarif = id_tarif');
                $this->db->where('id_agent = id_agent_master');
                $this->db->where('soft_delete =',0);
                $this->db->order_by('tgl_transaksi','ASC');
            } else{
                $this->db->select('*');
                $this->db->from('master_flowmeter,master_tenant,pengguna_jasa,master_lumpsum');
                $this->db->where('id_flow = id_master_flowmeter');
                $this->db->where('id_master_lumpsum = id_lumpsum');
                $this->db->where('pengguna_jasa_id = id_tarif');
            }

            $query = $this->db->get();

            if($query->num_rows() > 0){
                return $query->result();
            }
        }

        //fungsi database untuk delete data master pada ruko,darat dan laut
        public function delete_data($tipe,$id)
        {
            if($tipe == "darat"){
                $this->db->where('id_pengguna_jasa', $id);
                $this->db->delete("pembeli_darat");
            } else if($tipe == "ruko"){
                $this->db->where('id_flowmeter', $id);
                $this->db->delete("master_flowmeter");
            } else{
                $this->db->where('id_pengguna_jasa', $id);
                $this->db->delete("pembeli_laut");
            }
        }

        //fungsi database untuk master data ruko
        public function edit_master_ruko($data){
            $this->db->set('flowmeter_awal',$data['flowmeter_awal']);
            $this->db->where('id_flowmeter',$data['id_flowmeter']);
            $query = $this->db->update('master_flowmeter');

            $data = array(
                'ruko_id_flowmeter' => $data['id_flowmeter'],
                'tanggal_perekaman' => $data['tanggal_perekaman'],
                'flowmeter_hari_ini' => $data['flowmeter_awal']
            );
            $this->db->insert('penggunaan_air_ruko',$data);
            return $query;
        }

        public function get_datatables_ruko()
        {
            $this->_get_datatables_query_ruko();
            if($_POST['length'] != -1){
                $this->db->limit($_POST['length'], $_POST['start']);
            }
            $query = $this->db->get();
            return $query->result();
        }

        private function _get_datatables_query_ruko()
        {

            $this->db->from("pembeli_darat,master_flowmeter");
            $this->db->where("master_flowmeter_id_flowmaster = id_flowmeter");

            $i = 0;

            foreach ($this->column_search_ruko as $item) // loop column
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

                    if(count($this->column_search_ruko) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }

            if(isset($_POST['order'])) // here order processing
            {
                $this->db->order_by($this->column_order_ruko[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            }
            else if(isset($this->order_ruko))
            {
                $order = $this->order_ruko;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }

        public function count_filtered_ruko()
        {
            $this->_get_datatables_query_ruko();
            $query = $this->db->get();
            return $query->num_rows();
        }

        public function count_all_ruko()
        {
            $this->db->from("master_flowmeter");
            return $this->db->count_all_results();
        }

        //fungsi database untuk master data tenant
        public function edit_master_tenant($data){
            $this->db->set('flow_awal',$data['flowmeter_awal']);
            $this->db->where('id_flowmeter',$data['id_flowmeter']);
            $query = $this->db->update('master_flowmeter');

            return $query;
        }

        public function get_datatables_tenant()
        {
            $this->_get_datatables_query_tenant();
            if($_POST['length'] != -1){
                $this->db->limit($_POST['length'], $_POST['start']);
            }
            $query = $this->db->get();
            return $query->result();
        }

        private function _get_datatables_query_tenant()
        {

            $this->db->from("master_tenant,master_flowmeter");
            $this->db->where("id_master_flowmeter = id_flow");

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

        public function count_filtered_tenant()
        {
            $this->_get_datatables_query_tenant();
            $query = $this->db->get();
            return $query->num_rows();
        }

        public function count_all_tenant()
        {
            $this->db->from("master_tenant");
            return $this->db->count_all_results();
        }

        public function getFlowmeter(){
            $this->db->from('master_flowmeter');
            $query = $this->db->get();

            return $query->result();
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

        public function cekFlowAwal($id){
            $this->db->from('master_flowmeter');
            $this->db->where('id_flow',$id);
            $query = $this->db->get();

            if($query->row()->flowmeter_awal == 0)
                return TRUE;
        }

        public function cekFlowTenant($id){
            $this->db->from('master_tenant');
            $this->db->where('id_master_flowmeter',$id);
            $query = $this->db->get();

            if($query->row()->flow_awal == 0)
                return TRUE;
        }

        public function inputFlowAwal($data){
            $this->db->set('flowmeter_awal',$data['flowmeter_awal']);
            $this->db->where('id_flow',$data['id_flow']);
            $this->db->update('master_flowmeter');

            return $this->db->affected_rows();
        }

        public function edit_flow_tenant($data){
            $this->db->set('flowmeter_akhir',$data['flow_hari_ini']);
            $this->db->where('id_flow',$data['id_flow']);
            $this->db->update('master_flowmeter');

            $data = array(
                'flowmeter_tenant' => $data['id_flow'],
                'waktu_perekaman' => $data['waktu_perekaman'],
                'flow_hari_ini' => $data['flow_hari_ini'],
                'issued_at' => $data['issued_at'],
                'issued_by' => $data['issued_by']
            );

            $this->db->insert('transaksi_tenant',$data);

            return $query;
        }

        //fungsi database untuk master data flowmeter
        public function edit_master_flowmeter($data){
            $this->db->set('id_flowmeter',$data['id_flowmeter']);
            $this->db->set('nama_flowmeter',$data['nama_flowmeter']);
            $this->db->set('kondisi',$data['kondisi']);
            $this->db->set('flowmeter_awal',$data['flowmeter_awal']);
            $this->db->set('flowmeter_akhir',$data['flowmeter_akhir']);
            $this->db->where('id_master_flowmeter',$data['id_master_flowmeter']);
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
            return $this->db->count_all_results();
        }

        public function getKondisi(){
            $this->db->from('master_flowmeter');
            $query = $this->db->get();

            return $query->result();
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

        //fungsi database untuk master data sumur
        public function edit_master_sumur($data){
            $this->db->set('id_flowmeter',$data['id_flowmeter']);
            $this->db->set('nama_flowmeter',$data['nama_flowmeter']);
            $this->db->set('kondisi',$data['kondisi']);
            $this->db->set('flowmeter_awal',$data['flowmeter_awal']);
            $this->db->set('flowmeter_akhir',$data['flowmeter_akhir']);
            $this->db->where('id_master_flowmeter',$data['id_master_flowmeter']);
            $query = $this->db->update('master_flowmeter');

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
            return $this->db->count_all_results();
        }

        public function getPompa(){
            $this->db->from('master_pompa');
            $query = $this->db->get();

            return $query->result();
        }

        public function getIdPompa($id){
            $this->db->from('master_pompa');
            $this->db->where('id_master_pompa',$id);
            $query = $this->db->get();

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

        public function getIdFlowmeter($id){
            $this->db->from('master_flowmeter');
            $this->db->where('id_flow',$id);
            $query = $this->db->get();

            return $query->row();
        }

        public function get_datatables_pompa()
        {
            $this->_get_datatables_query_pompa();
            if($_POST['length'] != -1){
                $this->db->limit($_POST['length'], $_POST['start']);
            }
            $query = $this->db->get();
            return $query->result();
        }

        private function _get_datatables_query_pompa()
        {

            $this->db->from("master_pompa");

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

        public function count_filtered_pompa()
        {
            $this->_get_datatables_query_pompa();
            $query = $this->db->get();
            return $query->num_rows();
        }

        public function count_all_pompa()
        {
            $this->db->from("master_pompa");
            return $this->db->count_all_results();
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

        //fungsi database untuk master data laut
        public function get_datatables_laut()
        {
            $this->_get_datatables_query_laut();
            if($_POST['length'] != -1){
                $this->db->limit($_POST['length'], $_POST['start']);
            }
            $query = $this->db->get();
            return $query->result();
        }

        private function _get_datatables_query_laut()
        {

            $this->db->from("pembeli_laut");
            $i = 0;

            foreach ($this->column_search_laut as $item) // loop column
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

                    if(count($this->column_search_laut) - 1 == $i) //last loop
                        $this->db->group_end(); //close bracket
                }
                $i++;
            }

            if(isset($_POST['order'])) // here order processing
            {
                $this->db->order_by($this->column_order_laut[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            }
            else if(isset($this->order_laut))
            {
                $order = $this->order_laut;
                $this->db->order_by(key($order), $order[key($order)]);
            }
        }

        public function count_filtered_laut()
        {
            $this->_get_datatables_query_laut();
            $query = $this->db->get();
            return $query->num_rows();
        }

        public function count_all_laut()
        {
            $this->db->from("pembeli_laut");
            return $this->db->count_all_results();
        }

        public function delete_data_agent($id)
        {
            $this->db->where('id_agent', $id);
            $this->db->delete("master_agent");
        }

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

        private function _get_datatables_query()
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
            $this->db->select("*");
            $this->db->from('transaksi_darat');
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
            $this->db->where('realisasi_transaksi_laut_id_realisasi =',NULL);
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

        //fungsi untuk cancel order
        public function cancelOrder($data){
            if($data['tipe'] == "darat"){
                $this->db->set('soft_delete', 1 );
                $this->db->where('id_transaksi',$data['id']);
                $this->db->update('transaksi_darat');
            }else{
                $this->db->set('soft_delete', 1 );
                $this->db->where('id_transaksi',$data['id']);
                $this->db->update('transaksi_laut');
            }

            if($this->db->affected_rows() > 0)
                return TRUE;

        }

        public function cancelNota($data){
            if($data['tipe'] == "darat"){
                $this->db->set('batal_nota', 1 );
                $this->db->set('status_pembayaran', 0 );
                $this->db->where('no_kwitansi',$data['id']);
                $this->db->update('transaksi_darat');
            }

            if($this->db->affected_rows() > 0)
                return TRUE;

        }

        public function cancelKwitansi($data){
            if($data['tipe'] == "darat"){
                $this->db->set('batal_kwitansi', 1 );
                $this->db->where('id_transaksi',$data['id']);
                $this->db->update('transaksi_darat');
            }

            if($this->db->affected_rows() > 0)
                return TRUE;

        }
    }
?>