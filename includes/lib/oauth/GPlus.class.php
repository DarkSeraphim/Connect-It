<?php

    require('http.php');
    require('oauth_client.php');

    class GPlus implements OAuthService
    {
        public function doLogin()
        {

            $client = new oauth_client_class;
            $client->server = 'Google';

            // set the offline access only if you need to call an API
            // when the user is not present and the token may expire
            $client->offline = true;

            $client->debug = false;
            $client->debug_http = true;
            $client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
                dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/login_with_google.php';

            $client->client_id = '252365866515-dsdfgc0holm1aofidekqbf3a851e90vq.apps.googleusercontent.com'; $application_line = __LINE__;
            $client->client_secret = 'pw-0SHaqqUKPnkHAfBkfRRiM';

            if(strlen($client->client_id) == 0
            || strlen($client->client_secret) == 0)
                die('Please go to Google APIs console page '.
                    'http://code.google.com/apis/console in the API access tab, '.
                    'create a new client ID, and in the line '.$application_line.
                    ' set the client_id to Client ID and client_secret with Client Secret. '.
                    'The callback URL must be '.$client->redirect_uri.' but make sure '.
                    'the domain is valid and can be resolved by a public DNS.');

            /* API permissions
             */
            $client->scope = 'https://www.googleapis.com/auth/userinfo.email '.
                'https://www.googleapis.com/auth/userinfo.profile';
            if(($success = $client->Initialize()))
            {
                if(($success = $client->Process()))
                {
                    if(strlen($client->authorization_error))
                    {
                        $client->error = $client->authorization_error;
                        $success = false;
                    }
                    elseif(strlen($client->access_token))
                    {
                        $success = $client->CallAPI(
                            'https://www.googleapis.com/oauth2/v1/userinfo',
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

    return new GPlus();

?>