<?php

class Oauth extends MY_Controller{
    public function __construct() {
        parent::__construct();
    }
        
    public function index() {  
        // Include two files from google-php-client library in controller
        include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Client.php";
        include_once APPPATH . "libraries/google-api-php-client-master/src/Google/Service/Oauth2.php";
        
        // Store values in variables from project created in Google Developer Console
        $client_id = '963077506575-oq0bvm1cfog3hc5k2k6ustohah8tupc9.apps.googleusercontent.com';
        $client_secret = 'jS4eR1H2dops-_8f4jLE5fYX';
        $redirect_uri = 'http://apasih.qapps.site';
        $simple_api_key = 'AIzaSyDbvk33empnakIGBsJEm5mwUq6K0_u4RPY';
        
        // Create Client Request to access Google API
        $client = new Google_Client();
        $client->setApplicationName("Aplikasi Pelayanan Jasa Air Bersih PT. Kaltim Kariangau Terminal");
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->setDeveloperKey($simple_api_key);
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
    
    // Unset session and logout
    public function logout() {
        unset($_SESSION['access_token']);
        redirect(base_url());
    }
}

?>