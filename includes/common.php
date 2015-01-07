<?php

	define('BASEDIR', dirname(__DIR__));
    define('INCDIR', BASEDIR . "/includes");

	require('config.php');

    require_once('lib/Logger.class.php');
    require_once('lib/Utils.class.php');
    require_once('lib/Database.class.php');
    require_once('lib/Model.class.php');

    session_start();

    if(array_key_exists('id', $_SESSION))
    {
        $id = $_SESSION['id'];
        $user = User::load($id);
    }

?>