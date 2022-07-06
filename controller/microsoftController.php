<?php

require_once __SITE_PATH . '/vendor/autoload.php';

use myPHPnotes\Microsoft\Auth;

class MicrosoftController extends BaseController
{
    public function url() {
        return sprintf(
          "%s://%s%s",
          isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
          $_SERVER['SERVER_NAME'],
          $_SERVER['REQUEST_URI']
        );
    }

    public function index()
    {
        $tenant = "876309ef-7667-4cc4-8efb-3e0f87106946";
        $client_id = "fd4aad8e-efdb-46fb-82ed-24e62d44f6d5";
        $client_secret = "lNz8Q~f6o7-5~ZEZM-FI8iav8I4zmGEA7pfnla0X";
        $callback = strtok($this->url(),'?') . "?rt=callback/";
        $scopes = ["User.Read"];
        $microsoft = new Auth($tenant, $client_id, $client_secret, $callback, $scopes);
        
        header("location: " . $microsoft->getAuthUrl());
    }
}

?>