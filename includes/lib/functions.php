<?php 
require 'oauth/oauth_client.php';
$client = new oauth_client_class;
$baseUrlFb = "graph.facebook.com/v2.2";
$baseUrlGooglePlus = "https://www.googleapis.com/plus/v1";
$baseUrlInstagram = "https://api.instagram.com/v1";
$baseUrlTwitter = "https://api.twitter.com/1.1";
// client->CallAPI($url, $method, $parameters, $options, &$response);

function postMessage(array $params)
{
	$succeeded = True;
	//check if the social media are passed to the function
	if (array_key_exists('socialmedia', $params)) 
	{
		$socialMedia = $params['socialmedia'];
	} else 
	{
		die('Failed');	
	}
	
	//post the message to all social media and return succes or failed
	for (x = 0; x < array_count_values($params['socialmedia']); x++) 
	{
		if ($params['socialmedia'][$x] = 'facebook') 
		{
			//$fbId =
			$url = '$baseUrlFb' + $fbId + '/feed';
			$parameters['message'] = $params['text'];
		} else if ($params['socialmedia'][$x] = 'twitter') 
		{
			$url = '$baseUrlTwitter' + '/statuses/update.json';
			$parameters['status'] = $params['text'];
		}
		client->CallAPI($url, 'POST', $parameters, $options, &$response);
		
		//Check if posting the message has succeeded
		if (!(isset($response)))
		{
			$succeeded = False;
		}
	}
	
	//give feedback on the success of posting
	if ($succeeded) 
	{
		print 'Success';
	} else 
	{
		print 'Failed';
	}
}

function like(array $params)
{
	if ($params['socialmedia'] = 'facebook') 
	{
		$url = '$baseUrlFb' + '/' + $params['id'] + '/likes';
	} else if ($params['socialmedia'] = 'instagram') 
	{
		$url = '$baseUrlInstagram' + '/media/' + $params['id'] + '/likes';
		$parameters['message'] = $params['text'];
	} else 
	{
		Die('Failed')
	}
	client->CallAPI($url, 'POST', $parameters, $options, &$response);
	if (isset($response))
	{
		print 'Success';
	} else
	{
		print 'Failed';
	}
}

function retweetTwit(array $params)
{
	if (isset($params['id']))
	{
		$parameters['id'] = $params['id'];
	} else
	{
		die('Failed');
	}
	$url = '$baseUrlTwitter' + '/statuses/retweet/' + $params['id'] + '.json';
	client->CallAPI($url, 'POST', $parameters, $options, &$response);
	if (isset($response))
	{
		print 'Success';
	} else
	{
		print 'Failed';
	}
}

function getPosts(array $params)
{
	client->CallAPI($url, 'GET', $parameters, $options, &$response);
}

function comment(array $params, $requestType)
{
	if ($requestType == 'GET')
	{
		if ($params['socialmedia'] = 'facebook') 
		{
			$url = '$baseUrlFb' + '/' + $params['postid'] + '/comments';
			$parameters['message'] = $params['text'];
		} else if ($params['socialmedia'] = 'instagram') 
		{
			$url = '$baseUrlInstagram' + '/media/' + $params['postid'] + '/comments';
			$parameters['message'] = $params['text'];
		} else if ($params['socialmedia'] = 'googleplus') 
		{
			$url = '$baseUrlGooglePlus' + '/activities/' + $params['postid'] + '/comments';
		} else 
		{
			Die('Failed')
		}
		
		client->CallAPI($url, 'GET', $parameters, $options, &$response);
		if (isset($response))
		{
			print 'Success';
		} else
		{
			print 'Failed';
		}
		
	} else if($requestType == 'POST') 
	{
		if (array_key_exists('socialmedia', $params) && array_key_exists('postid', $params) && array_key_exists('message', $params)) 
		{
			$socialMedia = $params['socialmedia'];
		} else 
		{
			die('Failed');	
		}
		
		if ($params['socialmedia'] = 'facebook') 
		{
			$url = '$baseUrlFb' + $params['postid'] + '/comments';
			$parameters['message'] = $params['text'];
		} else if ($params['socialmedia'] = 'instagram') 
		{
			$url = '$baseUrlInstagram' + $params['postid'] + '/comments';
			$parameters['message'] = $params['text'];
		} else if ($params['socialmedia'] = 'twitter') 
		{
			$url = '$baseUrlTwitter' + $params['postid'] + '/comments';
			$parameters['message'] = $params['text'];
		} else 
		{
			Die('Failed')
		}
		
		client->CallAPI($url, 'POST', $parameters, $options, &$response);
		if (isset($response))
		{
			print 'Success';
		} else
		{
			print 'Failed';
		}
	}
}
?>