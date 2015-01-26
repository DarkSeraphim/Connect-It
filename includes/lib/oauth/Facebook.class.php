<?php

    require('http.php');
    require('oauth_client.php');

    class FaceBook implements OAuthService
    {
        public function doLogin()
        {
            $client = new oauth_client_class;
            $client->debug = false;
            $client->debug_http = true;
            $client->server = 'Facebook';
            $client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].'/oauth/facebook';

            $client->client_id = '971544396193677'; $application_line = __LINE__;
            $client->client_secret = 'd4a9277cd8c967d660e99f0fe1e459f5';

            if(strlen($client->client_id) == 0
            || strlen($client->client_secret) == 0)
                die('Please go to Facebook Apps page https://developers.facebook.com/apps , '.
                    'create an application, and in the line '.$application_line.
                    ' set the client_id to App ID/API Key and client_secret with App Secret');

            /* API permissions
             */
            $client->scope = 'email';
            if(($success = $client->Initialize()))
            {
                if(($success = $client->Process()))
                {
                    if(strlen($client->access_token))
                    {
                        $success = $client->CallAPI(
                            'https://graph.facebook.com/me', 
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

    return new FaceBook();

?>