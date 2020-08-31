<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $period = date('Y-m-d');
        #$period = date_format(date_create("2020-04-01"),"Y-m-d");
        $this->ceksesi();
        //$this->cekAccess();

        $resultKapal = $this->kapal->getTabelAirKapal($period);
        $resultDarat = $this->darat->getTabelAirDarat($period);
        $resultTenant = $this->tenant->getTabelAirTenant($period);

        $tabelKapal = array();
        $tabelDarat = array();
        $tabelTenant = array();

        if($resultKapal != NULL){
            foreach($resultKapal as $row){
                $tabelKapal[] = array("y"=> $row->jumlah_realisasi,"label" => $row->nama_agent);
            }
        }
        
        if($resultDarat != NULL){
            foreach($resultDarat as $row){
                $tabelDarat[] = array("y"=> $row->jumlah_permintaan,"label" => $row->nama_pengguna_jasa);
            }
        }

        if($resultTenant != NULL){
            foreach($resultTenant as $row){
                $tabelTenant[] = array("y"=> $row->jumlah_pakai,"label" => $row->nama_tenant);
            }
        }

        $data['tabelKapal'] = $tabelKapal;
        $data['tabelDarat'] = $tabelDarat;
        $data['tabelTenant'] = $tabelTenant;
        $data['period'] = $period;
        $data['air_kapal'] = number_format($this->kapal->getTotalAirKapal($period), 2, '.', '');
        $data['air_ruko'] = number_format($this->tenant->getTotalAirTenant($period), 2, '.', '');
        $data['air_darat'] = number_format($this->darat->getTotalAirDarat($period), 2, '.', '');
        $data['title']='PT KKT APP-AIR';
        $this->load->template('v_main',$data);
    }

    public function master($page){
        $this->ceksesi();
        $this->cekAccess();
        $title = str_replace('_',' ',$page);
        $this->navmenu('Data ' . ucwords($title), 'master/v_' . $page, '', '', '');
    }

    public function darat($page){
        $this->ceksesi();
        $this->cekAccess();
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
        $data['google_login_url'] = $this->google->get_login_url();
        $this->navmenu('APASIH KKT','v_login','','',$data);
    }

    public function error(){
        $data['title']  = 'MyAPPS';
        $data['title2'] = 'My<b>APPS</b>';
        $this->load->view('errors/',$data,'');
    }

    public function changePass(){
        $this->ceksesi();
        //$this->cekAccess();
        $this->navmenu('Ubah Password','v_changePass','','','');
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
