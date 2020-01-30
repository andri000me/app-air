<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->ceksesi();
        //$this->cekAccess();
        $data['title']='PT KKT APP-AIR';
        $this->load->template('v_main',$data);
    }

    public function master($page){
        $this->ceksesi();
        //$this->cekAccess();
        $title = str_replace('_',' ',$page);
        $this->navmenu('Data ' . ucwords($title), 'master/v_' . $page, '', '', '');
    }

    public function darat($page){
        $this->ceksesi();
        //$this->cekAccess();
        $title = str_replace('_',' ',$page);
        $this->navmenu( 'Data '.ucwords($title),'darat/v_'.$page,'','','');
    }

    public function kapal($page){
        $this->ceksesi();
        $this->cekAccess();
        $title = str_replace('_',' ',$page);
        $this->navmenu('Data '.ucwords($title),'kapal/v_'.$page,'','','');
    }

    public function tenant($page){
        $this->ceksesi();
        $this->cekAccess();
        $title = str_replace('_',' ',$page);
        $this->navmenu(''.ucwords($title),'tenant/v_'.$page,'','','');
    }

    public function report($page){
        $this->ceksesi();
        $this->cekAccess();
        $title = str_replace('_',' ',$page);
        $this->navmenu(''.ucwords($title),'report/v_'.$page,'','','');
    }

    public function monitoring($page){
        $this->ceksesi();
        $this->cekAccess();
        $title = str_replace('_',' ',$page);
        $this->navmenu(''.ucwords($title),'monitoring/v_'.$page,'','','');
    }

    public function pembayaran($page){
        $this->ceksesi();
        $this->cekAccess();
        $title = str_replace('_',' ',$page);
        $this->navmenu(''.ucwords($title),'pembayaran/v_'.$page,'','','');
    }

    public function login(){
        $this->navmenu('APASIH KKT','v_login','','','');
    }

    public function error(){
        $data['title']  = 'MyAPPS';
        $data['title2'] = 'My<b>APPS</b>';
        $this->load->view('errors/',$data,'');
    }

    //fungsi untuk pergantian view
    public function view() {
        $page = $_GET['id'];

        if($page == "darat"){
            $data['title'] = "Transaksi Darat";
            $data['pengguna'] = $this->data->get_pengguna("darat",$page);
            $this->load->template('v_input_darat',$data);
        }
        else if($page == "main_loket"){
            $data['title'] = "Dafter Permohonan";
            $this->load->template('v_main_loket',$data);
        }
        else if($page == "main_keuangan"){
            $data['title'] = "Dafter Tagihan Air Kapal";
            $this->load->template('v_main_keuangan',$data);
        }
        else if($page == "main_wtp"){
            $data['title'] = "Dafter Status Pengisian Kapal";
            $this->load->template('v_main_wtp',$data);
        }
        else if($page == "main_operasi"){
            $data['title'] = "Dafter Status Tagihan Air Kapal";
            $this->load->template('v_main_operasi',$data);
        }
        else if($page == "main_perencanaan"){
            $data['title'] = "Dafter Status Pelayanan Air Kapal";
            $this->load->template('v_main_perencanaan',$data);
        }
        else if($page == "laut"){
            $data['title'] = "Transaksi Laut";
            $data['pengguna'] = $this->data->get_pengguna("laut",$page);
            $this->load->template('v_input_laut',$data);
        }
        else if($page == "transaksi_darat"){
            $data['title'] = "Laporan Transaksi Darat";
            $this->load->template('v_laporan_transaksi_darat',$data);
        }
        else if($page == "transaksi_laut"){
            $data['title'] = "Laporan Transaksi Laut";
            $this->load->template('v_laporan_transaksi_laut',$data);
        }
        else if($page == "transaksi_ruko"){
            $data['title'] = "Laporan Transaksi Ruko";
            $this->load->template('v_laporan_transaksi_ruko',$data);
        }
        else if($page == "validasi_pembayaran_darat"){
            $data['title'] = "Validasi Pembayaran Air Darat";
            $data['pengguna'] = $this->data->get_pengguna("darat","darat");
            $this->load->template('v_validasi_pembayaran_darat',$data);
        }
        else if($page == "cancel_pembayaran_darat"){
            $data['title'] = "Pembatalan Pembayaran Air Darat";
            $data['pengguna'] = $this->data->get_pengguna("darat","darat");
            $this->load->template('v_batal_pembayaran_darat',$data);
        }
        else if($page == "cetak_laporan_darat"){
            $data['title'] = 'Laporan Pendapatan Air Darat'; //judul title
            $data['tipe'] = "darat";
            $this->load->template('v_laporan',$data);
        }
        else if($page == "cetak_laporan_laut"){
            $data['title'] = 'Laporan Pendapatan Air Kapal'; //judul title
            $data['tipe'] = "laut";
            $this->load->template('v_laporan',$data);
        }
        else if($page == "cetak_laporan_ruko"){
            $data['title'] = 'Laporan Pendapatan Air Ruko'; //judul title
            $data['tipe'] = "ruko";
            $this->load->template('v_laporan',$data);
        }
        else if($page == "cetak_laporan_flow"){
            $data['title'] = 'Laporan Pencatatan Flow Meter'; //judul title
            $data['tipe'] = "flow";
            $this->load->template('v_laporan',$data);
        }
        else if($page == "cetak_laporan_sumur"){
            $data['title'] = 'Laporan Pencatatan Sumur'; //judul title
            $data['tipe'] = "sumur";
            $this->load->template('v_laporan',$data);
        }
        else if($page == "monitoring_darat"){
            $data['title'] = 'Monitoring Layanan Jasa Air Darat'; //judul title
            $data['tipe'] = 'darat';
            $this->load->template('v_monitoring',$data);
        }
        else if($page == "monitoring_kapal"){
            $data['title'] = 'Monitoring Layanan Jasa Air Kapal'; //judul title
            $data['tipe'] = 'laut';
            $this->load->template('v_monitoring',$data);
        }
        else if($page == "tenant"){
            $data['title'] = 'Master Tenant'; //judul title
            if($this->session->userdata('role') == 'admin'){
                $data['tenant'] = $this->data->getFlowmeter();
                $this->load->template('v_tenant',$data);
            } else{
                $data['tenant'] = $this->data->getLumpsum();
                $this->load->template('v_tenant',$data);
            }
        }
        else if($page == "transaksi_tenant"){
            $data['title'] = 'Pencatatan Harian Tenant'; //judul title
            $this->load->template('v_input_ruko',$data);
        }
        else if($page == "flowmeter"){
            $data['title'] = 'Master Flow Meter'; //judul title
            $data['tenant'] = $this->data->getPompa();
            $this->load->template('v_flowmeter',$data);
        }
        else if($page == "sumur"){
            $data['title'] = 'Master Sumur'; //judul title
            $this->load->template('v_sumur',$data);
        }
        else if($page == "pompa"){
            $data['title'] = 'Master Pompa'; //judul title
            $data['tenant'] = $this->data->getIDSumur();
            $this->load->template('v_pompa',$data);
        }
        else if($page == "lumpsum"){
            $data['title'] = 'Master Lumpsum'; //judul title
            $data['lumpsum'] = $this->data->getIDTenant();
            $this->load->template('v_lumpsum',$data);
        }
        else if($page == "tagihan"){
            $data['title'] = 'Penagihan Ruko'; //judul title
            $this->load->template('v_tagihan',$data);
        }
        else if($page == "daftar_tagihan"){
            $data['title'] = 'Daftar Penagihan Ruko'; //judul title
            $this->load->template('v_tabel_penagihan',$data);
        }
        else if($page == "realisasi_pembayaran_darat"){
            $data['title'] = 'Realisasi Pembayaran Darat'; //judul title
            $this->load->template('v_realisasi_pembayaran_darat',$data);
        }
        else if($page == "realisasi_pembayaran_tenant"){
            $data['title'] = 'Realisasi Pembayaran Tenant'; //judul title
            $this->load->template('v_realisasi_pembayaran_tenant',$data);
        }
        else if($page == "riwayat_pencatatan_flow"){
            $data['title'] = 'Riwayat Pencatatan Flow Meter'; //judul title
            $this->load->template('v_riwayat_catat_flow',$data);
        }
        else if($page == "catat_sumur"){
            $data['title'] = 'Pencatatan Harian Sumur'; //judul title
            $this->load->template('v_pencatatan_sumur',$data);
        }
        else if($page == "riwayat_pencatatan_sumur"){
            $data['title'] = 'Riwayat Pencatatan Sumur'; //judul title
            $this->load->template('v_riwayat_catat_sumur',$data);
        }
        else{
            redirect('main');
        }

    }
    
    //fungsi untuk membuat notifikasi
    public function cekNotifKapal(){
        $result = $this->data->notifKapal();
        echo json_encode($result);
    }

    public function cekNotifDarat(){
        $result = $this->data->notifDarat();
        echo json_encode($result);
    }

    public function cekNotifAntar(){
        $result = $this->data->notifAntar();
        echo json_encode($result);
    }

    public function cekNotifRealisasi(){
        $result = $this->data->notifRealisasi();
        echo json_encode($result);
    }

    public function cekNotifBayar(){
        $result = $this->data->notifBayar();
        echo json_encode($result);
    }

    public function cekNotifBayarDarat(){
        $result = $this->data->notifBayarDarat();
        echo json_encode($result);
    }

    public function cekNotifBayarRuko(){
        $result = $this->data->notifBayarRuko();
        echo json_encode($result);
    }
}

?>
