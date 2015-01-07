<?php

if(!defined('BASEDIR'))
{
    die("Direct script access is not allowed");
}

class Logger
{

    const INFO = 0;

    const DEBUG = 1;

    const WARNING = 2;

    const SEVERE = 3;

    private static $instance;

    private $filepath = "";

    private function __construct()
    {
        $this->filepath = BASEDIR . "/log/";
        if(!file_exists($this->filepath) || !is_dir($this->filepath))
        {
            mkdir($this->filepath);
        }
    }

    private static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new Logger();
        }
        return self::$instance;
    }

    public static function log($level = 0, $message)
    {
        if(!isset($message) && is_string($level))
        {
            $message = $level;
            $level = Logger::INFO;
        }
        else if(!isset($message))
        {
            return FALSE;
        }
        self::getInstance()->_log($level, $message);
    }

    public function _log($level = 0, $entry)
    {

        $prefix = "";
        switch($level)
        {
            case Logger::DEBUG:
                $prefix = "DEBUG";
                break;
            case Logger::WARNING:
                $prefix = "WARNING";
                break;
            case Logger::SEVERE:
                $prefix = "SEVERE";
                break;
            default:
                $prefix = "INFO";
                break;
        }
        $date = date("H:i:s");
        $ip = $_SERVER['REMOTE_ADDR'];
        $message = "";

        $filepath = $this->filepath . date("y-m-d") . "-log.php";

        if (!file_exists($filepath))
        {
            $message .= "<"."?php  if (!defined('BASEDIR')) die('No direct script access allowed'); ?".">\n\n";
        }
        $message .= "[$date][$prefix] $ip --> $entry\n";

        if (!$fp = @fopen($filepath, "a"))
        {
            return FALSE;
        }

        flock($fp, LOCK_EX);
        fwrite($fp, $message);
        flock($fp, LOCK_UN);
        fclose($fp);
        return TRUE;        
    }
}

?>