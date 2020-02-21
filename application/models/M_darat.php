<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_darat extends MY_Model{
    var $tabel_transaksi_darat  = 'transaksi_darat';

    public function cancelNota($data){
        $this->db->set('batal_nota', 1 );
        $this->db->set('status_pembayaran', 0 );
        $this->db->where('no_kwitansi',$data['id']);
        $this->db->update('transaksi_darat');
        
        if($this->db->affected_rows() > 0)
            return TRUE;
    }

    //fungsi untuk cancel order
    public function cancelOrder($data){
        $this->db->set('soft_delete', 1 );
        $this->db->where('id_transaksi',$data['id']);
        $this->db->update('transaksi_darat');
        
        if($this->db->affected_rows() > 0)
            return TRUE;

    }

    public function cancelKwitansi($data){
        $this->db->set('batal_kwitansi', 1 );
        $this->db->where('id_transaksi',$data['id']);
        $this->db->update('transaksi_darat');

        if($this->db->affected_rows() > 0)
            return TRUE;
    }

    //fungsi database untuk pembuatan laporan, kwitansi dan tagihan
    function cetakKwitansi($id){
        $query = $this->db->select('*')
            //->from('transaksi_darat,pengguna_jasa,pembeli_darat')
            ->from('transaksi_darat,pembeli_darat')
            ->where('id_transaksi', $id)
            ->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa')
            //->where('pengguna_jasa_id_tarif = id_tarif')
            ->get();

        return $query->row();
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

    public function update_pembayaran_darat($where, $data){
        $this->db->insert('realisasi_transaksi_darat',$data);

        $this->db->set('status_invoice', 0);
        $this->db->set('status_pembayaran', 1);
        $this->db->where('id_transaksi',$where);
        $this->db->update($this->tabel_transaksi_darat);

        return $this->db->affected_rows();
    }

    public function update_realisasi($where, $data){
        $this->db->update($this->tabel_transaksi_darat, $data, $where);
        return $this->db->affected_rows();
    }

    public function get_by_id($id) {
        $this->db->from('transaksi_darat ,pembeli_darat,pengguna_jasa');
        $this->db->where('id_transaksi',$id);
        $this->db->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa');
        $this->db->where('pengguna_jasa_id_tarif = id_tarif');
        
        $query = $this->db->get();
        return $query->row();
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

    public function get_num_tabel_transaksi($tipe){
        $this->db->select('*');
        $this->db->from('transaksi_darat ,pembeli_darat,pengguna_jasa');
        $this->db->where('pengguna_jasa_id_tarif !=','1');
        $this->db->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa');
        $this->db->where('pengguna_jasa_id_tarif = id_tarif');
        $this->db->where('soft_delete = 0');
        $this->db->order_by('tgl_transaksi', 'DESC');

        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->num_rows();
        }
    }

    public function get_tabel_transaksi($config = ''){
        $this->db->select('*');
        $this->db->from('transaksi_darat ,pembeli_darat,pengguna_jasa');
        $this->db->where('pengguna_jasa_id_tarif !=','1');
        $this->db->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa');
        $this->db->where('pengguna_jasa_id_tarif = id_tarif');
        $this->db->where('transaksi_darat.soft_delete = 0');
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
        $query = $this->db->insert($this->tabel_transaksi_darat,$data);
        if($query){
            return TRUE;
        }
    }

}
?>