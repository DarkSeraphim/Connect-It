<?php
class apiHandler 
{
	//array with allowed requests and accompanying methods
	private $validRequests = array('lookup' => array('GET'), 'friendsuggest' => array('GET');
	
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