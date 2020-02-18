<?php 
require_once('Google/vendor/autoload.php');

class Google {
	protected $CI;

	public function __construct(){
		$this->CI =& get_instance();
        $this->CI->config->load('google');
        $this->client = new Google_Client();
        $config_data = $this->CI->config->item('google');
		$this->client->setClientId($config_data['client_id']);
		$this->client->setClientSecret($config_data['client_secret']);
		$this->client->setRedirectUri($config_data['redirect_uri']);
		$this->client->setScopes($config_data['scopes']);
	}

	public function get_login_url(){
		return  $this->client->createAuthUrl();
	}

	public function validate(){		
		if (isset($_GET['code'])) {
            $this->client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $this->client->getAccessToken();
		}
		if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $this->client->setAccessToken($_SESSION['access_token']);
            $plus = new Google_Service_Plus($this->client);
            $person = $plus->people->get('me');
            $info['id']=$person['id'];
            $info['email']=$person['emails'][0]['value'];
            $info['name']=$person['displayName'];
            $info['link']=$person['url'];
            $info['profile_pic']=substr($person['image']['url'],0,strpos($person['image']['url'],"?sz=50")) . '?sz=800';
            $info['first_name'] = $person['given_name'];
            $info['last_name'] = $person['family_name'];

            return  $info;
		}

	}

}