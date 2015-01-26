<?php

abstract class Media extends Model
{

	public static $medias = array();

	private $name;

	protected $userid;

	protected $session_id;

	private $access;

	public function __construct($name)
	{
		$this->name = $name;
		$this->userid = (new Property("userid", "INT"))->unique()->refers("user", "id");
		$this->session_id = new Property('session_id', 'INT');
		parent::__construct("media_".$name);
	}

	public function getName()
	{
		return $this->name;
	}

	public function getAccessToken()
	{
		$data = $this->getTokenData();
		return is_a($data, "TokenData") ? $data->getAccessToken() : NULL;
	}

	public function getAccessTokenSecret()
	{
		$data = $this->getTokenData();
		return is_a($data, "TokenData") ? $data->getAccessTokenSecret() : NULL;
	}

	public function getTokenData()
	{
		$sid = $this->session_id->get();
		if(isset($sid))
		{
			if(is_a($this->access, "TokenData"))
			{
				return $this->access;
			}
			$rows = Database::getInstance()->exec("SELECT * FROM `oauth_session` WHERE `id` = $sid LIMIT 1");
			if(!is_array($rows) || empty($rows[0]))
			{
				return FALSE;
			}
			return $this->access = new TokenData($rows[0]['access_token'], $rows[0]['access_token_secret']);
		}
		return FALSE;
	}

	public static function load($where = array())
	{
		if(is_array($where))
		{
			$where = array_key_exists('user', $where) ? $where['user'] : (array_key_exists('id', $where) ? $where['id'] : $where);
		}

		if(!$where)
		{
			return;
		}

		if(is_a($where, 'User'))
		{
			$where = $where->get('id');
		}

		if(!is_int($where))
		{
			$where = (int) $where;
		}

		if(!is_array($where))
		{
			$where = array('userid' => $where);
		}
		$return = array();
		foreach(Media::$medias as $media)
		{
			$m = $media::load($where);
			if(!empty($m))
			{
				array_push($return , $m);
			}
		}
		return $return;
	}
}

class TokenData
{
	private $token;

	private $secret;

	public function __construct($token, $secret)
	{
		if(empty($token) || empty($secret))
		{
			throw new Exception("Invalid token and/or secret");
		}
		$this->token = $token;
		$this->secret = $secret;
	}

	public function getAccessToken()
	{
		return $this->$token;
	}

	public function getAccessTokenSecret()
	{
		return $this->secret;
	}
}

$mediamodels = array_diff(scandir(INCDIR.'/models/media'), array('.', '..'));
foreach ($mediamodels as $mediamodel) 
{
	$classes = Utils::loadClasses($mediamodel, INCDIR.'/models/media', "Media");
	foreach ($classes as $classname => $class)
	{
		if((new ReflectionClass($class))->isAbstract())
		{
			continue;
		}
		$class::init();
		Media::$medias[] = $class;
	}
}

?>