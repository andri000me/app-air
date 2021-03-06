<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kapal extends MY_Model{
    var $tabel_transaksi_laut   = 'transaksi_laut';
    var $tabel_laut             = 'pembeli_laut';

    var $column_order_laut = array(null, 'id_pengguna_jasa','nama_vessel',null,null, null,null,null, null); //set column field database for datatable orderable
    var $column_search_laut = array('id_pengguna_jasa','id_vessel','nama_vessel'); //set column field database for datatable searchable
    var $order_laut = array('id_pengguna_jasa' => 'desc');

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

    public function cekPengisian($id){
        $this->db->where('pengisi =',NULL);
        $this->db->where('id_transaksi',$id);
        $this->db->from('transaksi_laut');
        $query = $this->db->get();

        if($query->num_rows())
            return TRUE;
    }

    //fungsi untuk cancel order
    public function cancelOrder($data){
        $this->db->set('soft_delete', 1 );
        $this->db->where('id_transaksi',$data['id']);
        $this->db->update('transaksi_laut');
        
         //input log
         $id_trans = $data['id'];
         $log = "Cancel Nota Air Kapal Dengan ID Transaksi ".$id_trans;
         $this->insertLog($log);

        if($this->db->affected_rows() > 0)
            return TRUE;
    }

    //fungsi database untuk pembuatan laporan, kwitansi dan tagihan
    function cetakKwitansi($id){
        $query = $this->db->select('*')
            ->from('transaksi_laut')
            ->join('pembeli_laut','pembeli_laut_id_pengguna_jasa = id_pengguna_jasa','left')
            ->join('master_agent','id_agent = id_agent_master','left')
            ->join('pengguna_jasa','id_tarif = pengguna_jasa_id_tarif','left')
            //->join('master_mata_uang','id_mata_uang = master_mata_uang.id','left')
            ->where('transaksi_laut.id_transaksi', $id)
            ->get();
        
        return $query->row();
    }

    public function update_pembayaran($where, $data){
        $this->db->insert('realisasi_transaksi_laut',$data);

        $this->db->set('status_invoice',0);
        $this->db->where('id_transaksi',$where);
        $this->db->update('transaksi_laut');

        //input log
        $id_trans = $where;
        $log = "Update Pembayaran Air Kapal Dengan ID Transaksi ".$id_trans;
        $this->insertLog($log);

        return $this->db->affected_rows();
    }

    public function update_realisasi($where, $data){
        $this->db->update($this->tabel_transaksi_laut, $data, $where);

         //input log
         $id_trans = $where['id_transaksi'];
         $log = "Update Realisasi Pengisian Air Kapal Dengan ID Transaksi ".$id_trans;
         $this->insertLog($log);

        return $this->db->affected_rows();
    }

    public function get_by_id($tipe,$id) {
        if($tipe == "laut_realisasi"){
            $this->db->from('transaksi_laut');
            $this->db->join('pembeli_laut','pembeli_laut_id_pengguna_jasa = id_pengguna_jasa','left');
            $this->db->join('pengguna_jasa','pengguna_jasa_id_tarif = id_tarif','left');
            $this->db->join('master_agent','id_agent = id_agent_master','left');
            //$this->db->join('master_mata_uang','id_mata_uang = master_mata_uang.id','left');
            $this->db->where('id_transaksi',$id);
        }
        else{
            $null = NULL;
            $this->db->from('transaksi_laut');
            $this->db->join('pembeli_laut','pembeli_laut_id_pengguna_jasa = id_pengguna_jasa','left');
            $this->db->where('id_transaksi',$id);
            $this->db->where('flowmeter_awal !=',$null);
            $this->db->where('flowmeter_akhir !=',$null);
        }

        $query = $this->db->get();
        return $query->row();
    }

    public function ubah_waktu_pengisian($data){
        $this->db->set('start_work',$data['waktu']);
        $this->db->set('status_pengerjaan','1');
        $this->db->set('last_modified',$data['waktu']);
        $this->db->set('modified_by',$data['user']);
        //$this->db->set('pengantar',$data['user']);
        $this->db->where('id_transaksi',$data['id']);
        $this->db->update('transaksi_laut');

        //input log
        $id_trans = $data['id'];
        $log = "Ubah Waktu Pengisian Air Kapal Dengan ID Transaksi ".$id_trans;
        $this->insertLog($log);

        return $this->db->affected_rows();
    }

    public function updatePrint($id){
        $this->db->set('status_print',1);
        $this->db->where('id_transaksi', $id);
        $this->db->update('transaksi_laut');

        return $this->db->affected_rows();
    }

    public function get_num_tabel_transaksi(){
        $this->db->select('*');
        $this->db->from('transaksi_laut');
        $this->db->join('pembeli_laut','pembeli_laut_id_pengguna_jasa = id_pengguna_jasa','left');
        $this->db->join('pengguna_jasa','pengguna_jasa_id_tarif = id_tarif','left');
        $this->db->join('master_agent','id_agent = id_agent_master','left');
        //$this->db->join('master_mata_uang','id_mata_uang = master_mata_uang.id','left');
        $this->db->order_by('transaksi_laut.tgl_transaksi', 'DESC');
        $this->db->group_by('transaksi_laut.id_transaksi');
        $this->db->where('transaksi_laut.soft_delete = 0');
        $this->db->where('status_invoice = 1');

        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->num_rows();
        }
    }

    public function get_tabel_transaksi($config = ''){
        $this->db->select('*');
        $this->db->from('transaksi_laut');
        $this->db->join('pembeli_laut','pembeli_laut_id_pengguna_jasa = id_pengguna_jasa','left');
        $this->db->join('pengguna_jasa','pengguna_jasa_id_tarif = id_tarif','left');
        $this->db->join('master_agent','id_agent = id_agent_master','left');
        //$this->db->join('master_mata_uang','id_mata_uang = master_mata_uang.id','left');
        $this->db->where('transaksi_laut.soft_delete = 0');
        $this->db->order_by('tgl_transaksi', 'DESC');
        $this->db->group_by('transaksi_laut.id_transaksi');

        if($config != NULL || $config != '')
            $query = $this->db->get('',$config['per_page'], $this->uri->segment(3));
        else
            $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result();
        }
    }

    public function input_transaksi($data){
        $query = $this->db->insert($this->tabel_transaksi_laut,$data);

         //input log
         $id_trans = $this->db->insert_id();
         $log = "Insert Permohonan Air Kapal Dengan ID Transaksi ".$id_trans;
         $this->insertLog($log);

        if($query){
            return TRUE;
        }
    }

    public function getTotalAirKapal($period){
        $sql = "SELECT sum(total_realisasi) as jumlah_realisasi from transaksi_laut
                where DATE_FORMAT(?,?) >= DATE_FORMAT(tgl_transaksi ,?) and 
                DATE_FORMAT(?,?) <= DATE_FORMAT(tgl_transaksi ,?) AND 
                soft_delete  = 0 and status_pengerjaan = 1 group by soft_delete";
        $query = $this->db->query($sql, array($period,'%Y%m','%Y%m',$period,'%Y%m','%Y%m'));

        if($query->num_rows() > 0)
            return $query->row()->jumlah_realisasi;
    }

    public function getTabelAirKapal($period){
        $sql = "select nama_agent ,sum(total_realisasi) as jumlah_realisasi
        from vw_transaksi_laut vtl
        where DATE_FORMAT(?,?) >= DATE_FORMAT(waktu_pelayanan ,?) and 
        DATE_FORMAT(?,?) <= DATE_FORMAT(waktu_pelayanan ,?) and status_pengerjaan = 1
        group by nama_agent";
        $query = $this->db->query($sql, array($period,'%Y%m','%Y%m',$period,'%Y%m','%Y%m'));

        if($query->num_rows() > 0)
            return $query->result();
    }
}
?>