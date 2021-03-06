<?php
class AjaxHandler 
{
	//array with allowed requests
	private $validRequests = array('postMessage' => array('POST'),'like' => array('POST'),
	'retweetTwit' => array('POST'),'comment' => array('POST', 'GET'),'getPosts' => array('GET'));
	
	private $params;
	private $requesType;
	private $request;
	
	function __construct()
	{
		# Request Type GET | POST
		$this->requestType = $_SERVER['REQUEST_METHOD'];
		$this->request = $_REQUEST;
		if ($this->requesType = 'GET') 
		{
			$this->params = $_GET;
		} else if ($this->requesType = 'POST') 
		{
			$this->params = $_POST;
		} else 
		{
			print 'Request failed. Make a valid GET or POST request';
		}
		
	}
	
	/* checks if the function given is valid and calls the function passing the params to handle the request further*/
	function handleRequest() 
	{
		if($params['function'] && in_array($params['function'],$validRequests) && in_array($requesType, $validRequests[$params['function']]) && function_exists($params['function']))
		{ 
			//unset the function index from the params
			unset($params['function']);
			//make function call
			$request['function']($params);
		} else 
		{
			print 'Invalid request. Please call the right function';
		}
	}
}
?>