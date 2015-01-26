<?php

	define('BASEDIR', dirname(__DIR__));
    define('INCDIR', BASEDIR . "/includes");

	require('config.php');

    require_once('lib/Logger.class.php');
    require_once('lib/Utils.class.php');
    require_once('lib/Database.class.php');
    require_once('lib/Model.class.php');

    session_start();

    function saveUser()
    {
        global $CIuser;
        if($CIuser)
        {
            $CIuser->save();
        }
    }  
    register_shutdown_function('saveUser');

    if(array_key_exists('id', $_SESSION))
    {
        $id = $_SESSION['id'];
        $CIuser = User::load(array('id' => $id));
    }
    if(!isset($CIuser) || !is_a($CIuser, 'User'))
    {
        $CIuser = new User();
    }

    /**
     * Example usage of the OAuth backend
     */
    $media = $CIuser->getMedia('twitter');
    $access_token = $media->getAccessToken();
    $access_token_secret = $media->getAccessTokenSecret();  

?>