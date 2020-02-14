<?php
//error_reporting(0);
//ini_set('display_errors', 0);
if (isset($_SERVER["HTTP_ORIGIN"]) === true) {
	$origin = $_SERVER["HTTP_ORIGIN"];
	$allowed_origins = array(
		"http://localhost/simpers",
        "https://localhost/simpers",
        "http://192.168.19.21/simpers",
        "https://192.168.19.21/simpers",
        "http://dev.kkt/simpers",
        "https://dev.kkt/simpers"
	);
	if (in_array($origin, $allowed_origins, true) === true) {
		header('Access-Control-Allow-Origin: ' . $origin);
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Allow-Methods: POST');
		header('Access-Control-Allow-Headers: Content-Type');
	}
	if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
		exit; // OPTIONS request wants only the policy, we can stop here
	}
}

date_default_timezone_set("Asia/Makassar");
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    var $md5_key = '##';
    
    // Store values in variables from project created in Google Developer Console
    var $client_id = '963077506575-oq0bvm1cfog3hc5k2k6ustohah8tupc9.apps.googleusercontent.com';
    var $client_secret = 'jS4eR1H2dops-_8f4jLE5fYX';
    var $redirect_uri = 'http://apasih.qapps.site';
    var $simple_api_key = 'AIzaSyDbvk33empnakIGBsJEm5mwUq6K0_u4RPY';

    public function __construct() {
        parent::__construct();
        $this->load->model('M_data','data'); //load model data yang berada di folder model
        $this->load->model('M_admin','admin');
        $this->load->model('M_darat','darat');
        $this->load->model('M_kapal','kapal');
        $this->load->model('M_master','master');
        $this->load->model('M_report','report');
        $this->load->model('M_tenant','tenant');
        $this->load->model('M_menu','menu');
        $this->load->model('M_role','role');

        $this->load->helper(array('url','form')); //load helper
        $this->load->library(array('form_validation','fpdf','dompdf_gen','Excel/PHPExcel','pagination'));
    }

    public function oauth2(){
        // Include two files from google-php-client library in controller
        include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Client.php";
        include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Service/Oauth2.php";

        // Create Client Request to access Google API
        $client = new Google_Client();
        $client->setApplicationName("Aplikasi Pelayanan Jasa Air Bersih PT. Kaltim Kariangau Terminal");
        $client->setClientId($this->client_id);
        $client->setClientSecret($this->client_secret);
        $client->setRedirectUri($this->redirect_uri);
        $client->setDeveloperKey($this->simple_api_key);
        $client->addScope("https://www.googleapis.com/auth/userinfo.email");
        
        // Send Client Request
        $objOAuthService = new Google_Service_Oauth2($client);
        
        // Add Access Token to Session
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
        
        // Set Access Token to make Request
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
        }
        
        // Get User Data from Google and store them in $data
        if ($client->getAccessToken()) {
            $userData = $objOAuthService->userinfo->get();

            //$data['userData'] = $userData;
            //$_SESSION['access_token'] = $client->getAccessToken();
            $data = array(
                'status'       => TRUE,
                'first_name'   => $userData->first_name,
                'last_name'    => $userData->last_name,
                'gender'       => $userData->last_name,
                'user_image'   => $userData->picture,
                'email'        => $userData->email,
                'username'     => '',
                'password'     => '',
                'role'         => '0',
                'created_date' => '',
                'access_token' => $client->getAccessToken(),
            );
            
            $this->session->set_userdata($data);
            $cekEmail = $this->admin->checkEmail($userData->email);

            if($cekEmail == FALSE){
                $user = array(
                    'first_name'   => $userData->first_name,
                    'last_name'    => $userData->last_name,
                    'gender'       => $userData->last_name,
                    'user_image'   => $userData->picture,
                    'email'        => $userData->email,
                    'username'     => strtolower($userData->first_name),
                    'password'     => password_hash(strtolower($userData->first_name."123"), PASSWORD_DEFAULT),
                    'date_created' => date("Y-m-d H:i:s", time()),
                );
                
                $this->admin->save($user);
            }
        } else {
            $authUrl = $client->createAuthUrl();
            //$data['authUrl'] = $authUrl;
            $_SESSION['authUrl'] = $authUrl;
        }
        // Load view and send values stored in $data
        //$this->load->view('google_authentication', $data);
        redirect(base_url());
    }

    function Koma($angka){
        return number_format($angka,2);
    }

    function Ribuan($angka){
        if($angka == '0')
            return '';
        elseif($angka < 100)
            return $angka.',-';
        else
            return number_format($angka,0,'','.').',-';
    }

    function konversi($x){

        $x = abs($x);
        $angka = array ("","Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";

        if($x < 12){
            $temp = " ".$angka[$x];
        }else if($x<20){
            $temp = $this->konversi($x - 10)." Belas";
        }else if ($x<100){
            $temp = $this->konversi($x/10)." Puluh". $this->konversi($x%10);
        }else if($x<200){
            $temp = " Seratus".$this->konversi($x-100);
        }else if($x<1000){
            $temp = $this->konversi($x/100)." Ratus".$this->konversi($x%100);
        }else if($x<2000){
            $temp = " Seribu".$this->konversi($x-1000);
        }else if($x<1000000){
            $temp = $this->konversi($x/1000)." Ribu".$this->konversi($x%1000);
        }else if($x<1000000000){
            $temp = $this->konversi($x/1000000)." Juta".$this->konversi($x%1000000);
        }else if($x<1000000000000){
            $temp = $this->konversi($x/1000000000)." Milyar".$this->konversi($x%1000000000);
        }

        return $temp;
    }

    function tkoma($x){
        $str = stristr($x,",");
        $ex = explode(',',$x);

        if(($ex[0]/10) >= 1){
            $a = abs($ex[0]);
        }
        $string = array("Nol", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan","Sepuluh", "Sebelas");
        $temp = "";

        $a2 = $ex[0]/10;
        $pjg = strlen($str);
        $i =1;


        if($a>=1 && $a< 12){
            $temp .= " ".$string[$a];
        }else if($a>12 && $a < 20){
            $temp .= $this->konversi($a - 10)." Belas";
        }else if ($a>20 && $a<100){
            $temp .= $this->konversi($a / 10)." Puluh". $this->konversi($a % 10);
        }else{
            if($a2<1){

                while ($i<$pjg){
                    $char = substr($str,$i,1);
                    $i++;
                    $temp .= " ".$string[$char];
                }
            }
        }
        return $temp;
    }

    function terbilang($x){
        if($x<0){
            $hasil = "Minus ".trim($this->konversi($x));
        }else{
            $poin = trim($this->tkoma($x));
            $hasil = trim($this->konversi($x));
        }

        if($poin){
            $hasil = $hasil." Koma ".$poin;
        }else{
            $hasil = $hasil;
        }
        return $hasil;
    }

    function indonesian_date ($date_format = 'D, j-M-Y',$timestamp = '', $suffix = '') {
        if (trim ($timestamp) == '')
        {
            $timestamp = time ();
        }
        elseif (!ctype_digit ($timestamp))
        {
            $timestamp = strtotime ($timestamp);
        }
        # remove S (st,nd,rd,th) there are no such things in indonesia :p
        $date_format = preg_replace ("/S/", "", $date_format);
        $pattern = array (
            '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
            '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
            '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
            '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
            '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
            '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
            '/April/','/June/','/July/','/August/','/September/','/October/',
            '/November/','/December/',
        );
        $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
            'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
            'Jan ','Feb ','Mar ','Apr ','Mei ','Jun ','Jul ','Ags ','Sep ','Okt ','Nov ','Des ',
            'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
            'Oktober','November','Desember',
        );
        $date = date ($date_format, $timestamp);
        $date = preg_replace ($pattern, $replace, $date);
        $date = "{$date} {$suffix}";

        return $date;
    }

    function rupiah($angka){
        //$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

    public function navmenu($title,$page,$err='',$info='',$attr=''){
        $data['title']=$title;
        $data['err']=$err;
        $data['info']=$info;
        $data['attr']=$attr;
        $this->load->template($page,$data);
    }

    public function ceksesi(){
        if($this->session->has_userdata('status','username','password')){
            $uid    = $_SESSION['username'];
            $sesi   = $_SESSION['password'];
            $result = $this->_cekUser($uid,$sesi);
            
            if ($result['status'] == FALSE) {
                $data = array(
                    'status',
                    'nama',
                    'email',
                    'username',
                    'password',
                    'role',
                    'created_date',
                );
                $this->session->unset_userdata($data);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your Session Has Ended</div>');
                redirect('main/login');
            }
        }else{
            $this->session->unset_userdata($data);
            //$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your Session Has Ended</div>');
            redirect('main/login');
        }
    }

    public function cekAccess(){
        $role   = $_SESSION['role'];
        $menu   = $this->uri->segment(2).'/'.$this->uri->segment(3);
        $menuID = $this->menu->getMenuID($menu);
        $access = $this->_cekUserAccess($role,$menuID);

        if($menu == '/'){
            //do nothing
        }else if($access['status'] == FALSE){
                $_SESSION['access_display'] = 'Anda Tidak Mempunyai Hak Akses Untuk Halaman Ini';
                redirect('main');
        }else{
            //do nothing
        }
    }

    private function _cekUser($uid,$sesi){
        $result = $this->admin->cekSesi($uid,$sesi);
        return $result;
    }

    private function _cekUserAccess($role,$menu){
        $result = $this->admin->cekUserAccess($role,$menu);
        return $result;
    }

    function singleUpload($upload_name,$folder,$filename){
        if(!is_dir('./dokumen/'.$folder)){
            mkdir('./dokumen/'.$folder,0775,true);
        }

        // $config['file_name'] = $user_name.date('YmdHis').".".$extension;
        $config['file_name']     = $filename;
        $config['allowed_types'] = 'pdf|png|jpg|jpeg|bmp';
        $config['upload_path']   = 'dokumen/'.$folder."/";

        $this->upload->initialize($config);

        if ($this->upload->do_upload($upload_name)){
            $arrayRetutn['upload'] = 'True';
            $arrayRetutn['data'] = $this->upload->data();
        } else {
            $arrayRetutn['upload'] = 'False';
            $arrayRetutn['error'] = $this->upload->display_errors();
        }
        //echo '<pre>';print_r($arrayRetutn);echo '</pre>'; die;
        return $arrayRetutn;
    }

    function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);

        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }

    public function Romawi($angka) {
        $hsl = "";
        if ($angka < 1 || $angka > 5000) {
            // Statement di atas buat nentuin angka ngga boleh dibawah 1 atau di atas 5000
            $hsl = "Batas Angka 1 s/d 5000";
        } else {
            while ($angka >= 1000) {
                // While itu termasuk kedalam statement perulangan
                // Jadi misal variable angka lebih dari sama dengan 1000
                // Kondisi ini akan di jalankan
                $hsl .= "M";
                // jadi pas di jalanin , kondisi ini akan menambahkan M ke dalam
                // Varible hsl
                $angka -= 1000;
                // Lalu setelah itu varible angka di kurangi 1000 ,
                // Kenapa di kurangi
                // Karena statment ini mengambil 1000 untuk di konversi menjadi M
            }
        }
        if ($angka >= 500) {
            // statement di atas akan bernilai true / benar
            // Jika var angka lebih dari sama dengan 500
            if ($angka > 500) {
                if ($angka >= 900) {
                    $hsl .= "CM";
                    $angka -= 900;
                } else {
                    $hsl .= "D";
                    $angka-=500;
                }
            }
        }
        while ($angka>=100) {
            if ($angka>=400) {
                $hsl .= "CD";
                $angka -= 400;
            } else {
                $angka -= 100;
            }
        }
        if ($angka>=50) {
            if ($angka>=90) {
                $hsl .= "XC";
                $angka -= 90;
            } else {
                $hsl .= "L";
                $angka-=50;
            }
        }
        while ($angka >= 10) {
            if ($angka >= 40) {
                $hsl .= "XL";
                $angka -= 40;
            } else {
                $hsl .= "X";
                $angka -= 10;
            }
        }
        if ($angka >= 5) {
            if ($angka == 9) {
                $hsl .= "IX";
                $angka-=9;
            } else {
                $hsl .= "V";
                $angka -= 5;
            }
        }
        while ($angka >= 1) {
            if ($angka == 4) {
                $hsl .= "IV";
                $angka -= 4;
            } else {
                $hsl .= "I";
                $angka -= 1;
            }
        }
        return ($hsl);
    }
}
?>