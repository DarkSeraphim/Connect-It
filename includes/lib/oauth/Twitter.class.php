<?php

    namespace OAuth;

    require('http.php');
    require('oauth_client.php');
    require('database_oauth_client.php');

    class Twitter implements \OAuthService
    {
        public function doLogin()
        {
            $client = new \database_oauth_client_class("twitter");
            $client->debug = true;
            $client->debug_http = true;
            $client->server = 'Twitter';
            $client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']).'/oauth/twitter';
            //die($client->redirect_uri);
            // $client->redirect_uri = 'oob';
            /*
             * Was this script included defining the pin the
             * user entered to authorize the API access?
             */
            if(defined('OAUTH_PIN'))
                $client->pin = OAUTH_PIN;

            $client->client_id = 'FVG7I9ZfsH6kDJogyTtLlKk8T'; $application_line = __LINE__;
            $client->client_secret = 'YsViiQ7GvB9lCoB8yne7yRHoUfMikWUQMUXmddPfQeXaf6C4Ro';

            if(strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
            {
                 die('Please go to Twitter Apps page https://dev.twitter.com/apps/new , '.
                'create an application, and in the line '.$application_line.
                ' set the client_id to Consumer key and client_secret with Consumer secret. '.
                'The Callback URL must be '.$client->redirect_uri.' If you want to post to '.
                'the user timeline, make sure the application you create has write permissions');
            }

            if(($success = $client->Initialize()))
            {
                if(($success = $client->Process()))
                {
                    if(strlen($client->access_token))
                    {
                        $success = $client->CallAPI('https://api.twitter.com/1.1/account/verify_credentials.json', 'GET', array(), array('FailOnAccessError'=>true), $user);
                    }
                }
                $success = $client->Finalize($success);
            }

            if($client->exit)
                exit;

            echo "<pre>";

            //var_dump($client);

            echo "<br/><br/>";

            //var_dump($user);

            echo "<br/><br/>";

            //var_dump($success);

            // We now have $success, $client, $client->access_token, $user, $client->error
            return $success;
        }
    }

    return new Twitter();
?>