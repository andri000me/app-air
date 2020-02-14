<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends MY_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        $this->ceksesi();
        //$this->cekAccess();
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
            $data['authUrl'] = $authUrl;
            //$_SESSION['authUrl'] = $authUrl;
        }
        // Load view and send values stored in $data
        //$this->load->view('google_authentication', $data);
        //redirect(base_url());
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
        $this->navmenu('APASIH KKT','v_login','','','');
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
