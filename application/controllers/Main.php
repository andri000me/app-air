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
