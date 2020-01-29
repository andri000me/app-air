<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class M_report extends MY_Model{
    function getDataLaporan($tgl_awal = '',$tgl_akhir = '', $tipe){
        if($tipe == "darat"){
            $this->db->select('*');
            $this->db->from('transaksi_darat , pembeli_darat');
            $this->db->where('tgl_transaksi BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
            $this->db->where('pembeli_darat_id_pengguna_jasa = id_pengguna_jasa');
            $this->db->where('transaksi_darat.soft_delete =',0);
            $this->db->order_by('tgl_transaksi','ASC');
        }
        else if($tipe == "darat_keuangan"){
            $this->db->select('*');
            $this->db->from('transaksi_darat');
            $this->db->join('pembeli_darat','pembeli_darat_id_pengguna_jasa = id_pengguna_jasa','left outer');
            //$this->db->join('pengguna_jasa','pengguna_jasa_id_tarif = id_tarif','left outer');
            $this->db->join('realisasi_transaksi_darat','id_ref_transaksi = id_transaksi','left outer');
            $this->db->where('tgl_transaksi BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
            $this->db->where('transaksi_darat.soft_delete =',0);
            $this->db->order_by('tgl_transaksi','ASC');
        }
        else if($tipe == "laut"){
            $this->db->select('*');
            $this->db->from('realisasi_transaksi_laut');
            $this->db->join('transaksi_laut','id_ref_transaksi = id_transaksi','left');
            $this->db->join('pembeli_laut','pembeli_laut_id_pengguna_jasa = id_pengguna_jasa','left');
            $this->db->join('master_agent','id_agent = id_agent_master','left');
            $this->db->where('tgl_transaksi BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
            $this->db->where('transaksi_laut.soft_delete =',0);
            $this->db->order_by('tgl_transaksi','ASC');
        }
        else if($tipe == "laut_operasi"){
            $this->db->select('*');
            $this->db->from('transaksi_laut , pembeli_laut ,master_agent');
            $this->db->where('tgl_transaksi BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
            $this->db->where('pembeli_laut_id_pengguna_jasa = id_pengguna_jasa');
            $this->db->where('id_agent = id_agent_master');
            $this->db->where('transaksi_laut.soft_delete =',0);
            $this->db->order_by('tgl_transaksi','ASC');
        }
        else if($tipe == "flow"){
            $this->db->select('*');
            $this->db->from('master_flowmeter');
            //$this->db->join('pencatatan_flow','id_ref_flowmeter = id_flow','left');
            $this->db->where('id_flow >',0);
            //$this->db->where('waktu_perekaman BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
            $this->db->where('status_aktif',1);
        }
        else if($tipe == "sumur"){
            /*
            $this->db->select('*');
            $this->db->from('master_sumur,pencatatan_sumur,master_flowmeter,master_pompa');
            $this->db->where('id_ref_flowmeter = id_flow');
            $this->db->where('id_ref_pompa = id_master_pompa');
            $this->db->where('id_ref_sumur = id_master_sumur');
            $this->db->where('waktu_rekam_awal BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
            $this->db->where('status_pencatatan',1);
            $this->db->order_by('waktu_rekam_awal','ASC');
            */
            $this->db->select('*');
            $this->db->from('view_pencatatan_sumur');
            $this->db->where('waktu_rekam_awal BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
            $this->db->order_by('waktu_rekam_awal','ASC');
        }
        else if($tipe == "ruko_keuangan"){
            $this->db->select('*');
            $this->db->from('realisasi_transaksi_tenant');
            $this->db->join('transaksi_tenant','id_ref_transaksi = id_transaksi','left');
            $this->db->join('master_flowmeter','id_flow = transaksi_tenant.id_ref_flowmeter','left');
            $this->db->join('master_tenant','id_flow = master_tenant.id_ref_flowmeter','left');
            $this->db->join('master_lumpsum','id_ref_tenant = id_tenant','left');
            $this->db->where('tgl_transaksi BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
            //$this->db->where('soft_delete',0);
            $this->db->order_by('id_realisasi','ASC');
        }
        else{
            $tgl_sekarang = date('Y-m-d',time());
            $this->db->select('*');
            $this->db->from('transaksi_tenant');
            $this->db->join('master_flowmeter','id_flow = transaksi_tenant.id_ref_flowmeter','left');
            $this->db->join('master_tenant','id_flow = master_tenant.id_ref_flowmeter','left');
            $this->db->join('master_lumpsum','id_ref_tenant = id_tenant','left');
            $this->db->where('transaksi_tenant.tgl_transaksi BETWEEN "'. date('Y-m-d H:i:s', strtotime($tgl_awal." 00:01:00")). '" and "'. date('Y-m-d H:i:s', strtotime($tgl_akhir." 23:59:00")).'"');
            $this->db->where('transaksi_tenant.soft_delete',0);
            $this->db->or_where('master_lumpsum.waktu_kadaluarsa >=',$tgl_sekarang);
            $this->db->order_by('master_tenant.id_tenant','ASC');
        }

        $query = $this->db->get();

        if($query->num_rows() > 0){
            return $query->result();
        }
    }
}

?>