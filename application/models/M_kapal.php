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
        
        if($this->db->affected_rows() > 0)
            return TRUE;
    }

    //fungsi database untuk pembuatan laporan, kwitansi dan tagihan
    function cetakKwitansi($id){
        $query = $this->db->select('*')
            ->from('transaksi_laut,pembeli_laut,master_agent')
            ->where('id_transaksi', $id)
            ->where('pembeli_laut_id_pengguna_jasa = id_pengguna_jasa')
            ->where('id_agent = id_agent_master')
            ->get();
        
        return $query->row();
    }

    public function update_pembayaran($where, $data){
        $this->db->insert('realisasi_transaksi_laut',$data);

        $this->db->set('status_invoice',0);
        $this->db->where('id_transaksi',$where);
        $this->db->update('transaksi_laut');

        return $this->db->affected_rows();
    }

    public function update_realisasi($where, $data){
        $this->db->update($this->tabel_transaksi_laut, $data, $where);
        return $this->db->affected_rows();
    }

    public function get_by_id($tipe,$id) {
        if($tipe == "laut_realisasi"){
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

    public function ubah_waktu_pengisian($data){
        $this->db->set('start_work',$data['waktu']);
        $this->db->set('status_pengerjaan','1');
        $this->db->set('last_modified',$data['waktu']);
        $this->db->set('modified_by',$data['user']);
        //$this->db->set('pengantar',$data['user']);
        $this->db->where('id_transaksi',$data['id']);
        $this->db->update('transaksi_laut');

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
        $this->db->from('transaksi_laut ,pembeli_laut,pengguna_jasa,master_agent');
        $this->db->where('pembeli_laut_id_pengguna_jasa = id_pengguna_jasa');
        $this->db->where('pengguna_jasa_id_tarif = id_tarif');
        $this->db->where('id_agent = id_agent_master');
        $this->db->order_by('tgl_transaksi', 'DESC');
        $this->db->where('soft_delete = 0');
        $this->db->where('status_invoice = 1');

        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->num_rows();
        }
    }

    public function get_tabel_transaksi($config = ''){
        $this->db->select('*');
        $this->db->from('transaksi_laut ,pembeli_laut,pengguna_jasa,master_agent');
        $this->db->where('pembeli_laut_id_pengguna_jasa = id_pengguna_jasa');
        $this->db->where('pengguna_jasa_id_tarif = id_tarif');
        $this->db->where('id_agent = id_agent_master');
        $this->db->where('transaksi_laut.soft_delete = 0');
        $this->db->order_by('tgl_transaksi', 'DESC');

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
        if($query){
            return TRUE;
        }
    }

}
?>