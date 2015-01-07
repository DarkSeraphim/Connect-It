<?php

class User extends Model
{

	protected $id;

	protected $email;

	private $accessToken;

	private $media = array();

	public function __construct()
	{
		$this->id = (new Property("id", "INT"))->primary()->autoIncrement();
		$this->email = (new Property("email", "VARCHAR", 50, "example@example.com"))->unique();
		parent::__construct("user");
	}

	public function addMedia($media)
	{
		$this->media[] = $media;
	}

	public function save()
	{
		parent::save();
		foreach($this->media as $media)
		{
			$media->save();
		}
	}

	public static function load($where = array())
	{
		parent::load($where);
		Media::load(array('userid' => $this->id->get()));
	}

	public function setAccessToken($accessToken)
	{
		$this->accessToken = $accessToken;
	}

	public function getAccessToken()
	{
		return $this->accessToken;
	}

}

?>