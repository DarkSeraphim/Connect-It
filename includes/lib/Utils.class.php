<?php

    class Utils
    {

        private static $loaded = array();
        
        public static function loadClasses($files, $basedir = NULL, $super = NULL) 
        {
            if(!$basedir)
            {
                $basedir = INCDIR;
            }

            if(!$files)
            {
                return array();
            }
            if(!is_array($files))
            {
                $files = array($files);
            }
            $return = array();
            foreach($files as $file)
            {
                $file = $basedir . "/" . $file;

                if(is_dir($file) || !file_exists($file))
                {
                    continue;
                }

                if(array_key_exists($file, Utils::$loaded))
                {
                    array_merge($return, Utils::$loaded[$file]);
                    continue;
                }
                
                $contents = file_get_contents($file);

                if(!preg_match_all("/(?:<\?(?:php)?([\s\S]*)(?:\?>))|(?:<\?(?:php)?([\s\S]*)$)/", $contents, $matches, PREG_SET_ORDER) || !$matches)
                {
                    continue;
                }
                foreach($matches as $match)
                {
                    eval($match[1]);
                }
                
                if(!preg_match_all("/class ([a-zA-Z0-9_\\$]+)" . ($super ? " (?:extends)|(?:implements) $super" : "") . "/", $contents, $matches, PREG_SET_ORDER) || !$matches)
                {
                    continue;
                }
                Utils::$loaded[$file] = array();
                $class;
                foreach($matches as $match)
                {
                    $class = $match[1];
                    Utils::$loaded[$file][] = $class;
                    $return[] = $class;
                }
            }
            return $return;
        }

    }

?>