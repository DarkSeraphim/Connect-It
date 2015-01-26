<?php

    require_once 'includes/common.php';

    $services = array('twitter' => 'Twitter.class.php', 'facebook', 'gplus' => 'GPlus.class.php', 'instagram');

    if(!array_key_exists('service', $_GET) || in_array($_GET['service'] = strtolower($_GET['service']), $services))
    {
        header('HTTP/1.1 400 Bad Request', true, 400);
        die("Unknown service");
    }

    interface OAuthService
    {
        public function doLogin();
    }

    $service = require 'includes/lib/oauth/'.$services[$_GET['service']];
    if(!is_a($service, 'OAuthService'))
    {
        die("Service not an OAuth service");
    }

    $service->doLogin();
    
?>