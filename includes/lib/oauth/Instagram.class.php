<?php

    require('http.php');
    require('oauth_client.php');

    class Instagram implements OAuthService
    {
        public function doLogin()
        {
            $client = new oauth_client_class;
            $client->debug = false;
            $client->debug_http = true;
            $client->server = 'Instagram';
            $client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].'/oauth/instagram';

            $client->client_id = ''; $application_line = __LINE__;
            $client->client_secret = '';

            if(strlen($client->client_id) == 0
            || strlen($client->client_secret) == 0)
                die('Please go to Instagram Apps page http://instagram.com/developer/register/ , '.
                    'create an application, and in the line '.$application_line.
                    ' set the client_id to client id key and client_secret with client secret');

            /* API permissions
             */
            $client->scope = 'basic';
            if(($success = $client->Initialize()))
            {
                if(($success = $client->Process()))
                {
                    if(strlen($client->access_token))
                    {
                        $success = $client->CallAPI(
                            'https://api.instagram.com/v1/users/self/', 
                            'GET', array(), array('FailOnAccessError'=>true), $user);
                    }
                }
                $success = $client->Finalize($success);
            }
            if($client->exit)
                exit;

            echo "<pre>";

            var_dump($client);

            echo "<br/><br/>";

            var_dump($user);

            echo "<br/><br/>";

            var_dump($success);

            // We now have $success, $client, $client->access_token, $user, $client->error
            return $success;
        }
    }

    return new Instagram();

?>