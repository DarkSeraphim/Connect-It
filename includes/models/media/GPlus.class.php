<?php

class GPlus extends Media
{

    protected $id;

	public function __construct()
	{
        $this->id = (new Property("id", "INT"))->primary()->autoIncrement();
		parent::__construct("gplus");
	}

    public static function load($where = array())
    {
        return Model::newInstance($where);
    }

}
?>