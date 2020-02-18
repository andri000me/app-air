<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
| 
| To get API details you have to create a Google Project
| at Google API Console (https://console.developers.google.com)
| 
|  client_id         string   Your Google API Client ID.
|  client_secret     string   Your Google API Client secret.
|  redirect_uri      string   URL to redirect back to after login.
|  application_name  string   Your Google application name.
|  api_key           string   Developer key.
|  scopes            string   Specify scopes
*/
$config['google']['client_id']        = '963077506575-oq0bvm1cfog3hc5k2k6ustohah8tupc9.apps.googleusercontent.com';
$config['google']['client_secret']    = 'jS4eR1H2dops-_8f4jLE5fYX';
$config['google']['redirect_uri']     = 'https://apasih.qapps.site/admin/oauth2callback';
$config['google']['application_name'] = 'APASIH PT. Kaltim Kariangau Terminal';
$config['google']['api_key']          = 'AIzaSyDbvk33empnakIGBsJEm5mwUq6K0_u4RPY';
$config['google']['scopes']           = array(
                                            "https://www.googleapis.com/auth/plus.login",
                                            "https://www.googleapis.com/auth/plus.me",
                                            "https://www.googleapis.com/auth/userinfo.email",
                                            "https://www.googleapis.com/auth/userinfo.profile"
                                        );