<?php

class Twitter extends Media
{

    protected $id;

    public function __construct()
    {
        $this->id = (new Property("id", "INT"))->primary()->autoIncrement();
        parent::__construct("twitter");
    }

    public static function load($where = array())
    {
        $model = Model::newInstance(get_class(), $where);
        return $model;
    }

}
?>