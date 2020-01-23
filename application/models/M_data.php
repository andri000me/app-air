<?php
class M_data extends MY_Model {
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