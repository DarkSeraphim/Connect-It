<?php

class User extends Model
{

	protected $id;

	private $media = array();

	public function __construct()
	{
		$this->id = (new Property("id", "INT"))->primary()->autoIncrement();
		parent::__construct("user");
	}

	public function addMedia($media)
	{
		$this->media[$media->getName()] = $media;
	}

	public function getMedia($media)
	{
		if(array_key_exists($media, $this->media))
		{
			return $this->media[$media];
		}
		switch($media)
		{
			case 'twitter':
				$media = $this->media['twitter'] = new \Twitter();
				break;
			case 'facebook':
				$media = $this->media['facebook'] = new \FaceBook();
				break;
			case 'gplus':
				$media = $this->media['gplus'] = new \GPlus();
				break;
			case 'instagram':
				$media = $this->media['instagram'] = new \Instagram();
				break;
			default:
				$media = FALSE;
		}

		if($media && !$media->get('userid', 0))
		{
			$media->set('userid', $this->get('id'));
			$media->notDirty();
		}
		return $media;
	}

	public function save()
	{
		$forceSave = FALSE;
		foreach($this->media as $k=>$media)
		{
			$forceSave = $forceSave || $media->isDirty();
		}

		if($forceSave)
		{
			// Flag the model as dirty
			$this->set('id', $this->get('id'));
		}
		parent::save();
		$id = $this->get('id', 0);
		if(!$id)
		{
			$db = Database::getInstance();
			$id = $db->getInsertedId();
			$this->set('id', $id);
		}
		foreach($this->media as $media)
		{
			$media->set('userid', $id);
			$media->save();
		}
		if(session_status() === PHP_SESSION_ACTIVE)
		{
			$_SESSION['id'] = $this->get('id');
		}
	}

	public static function load($where = array())
	{
		$user = parent::load($where);
		if($user && array_key_exists('id', $where))
		{
			$media = Media::load(array('userid' => $where['id']));
			if(is_array($media))
			{
				foreach($media as $m)
				{
					$user->addMedia($m);
				}
			}
		}
		return $user;
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