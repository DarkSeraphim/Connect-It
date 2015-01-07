<?php

abstract class Media extends Model
{

	public static $medias = array();

	protected $uid;

	public function __construct($name)
	{
		$this->uid = (new Property("userid", "INT"))->unique()->refers("user", "id");
		parent::__construct("media_".$name);
	}

	public static function load($where = array())
	{

		if(is_array($where))
		{
			$where = array_key_exists('user', $where) ? $where['user'] : (array_key_exists('id', $where) ? $where['id'] : NULL);
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

		foreach(Media::$medias as $media)
		{
			$m = $media::load(array('userid' => $where));
			if(!empty($m))
			{
				$user->addMedia($m);
			}
		}
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