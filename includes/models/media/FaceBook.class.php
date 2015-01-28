<?php

class FaceBook extends Media
{

    protected $id;

    public function __construct()
    {
        $this->id = (new Property("id", "INT"));
        $this->id = $this->id->primary()->autoIncrement();
        parent::__construct("facebook");
    }

    public static function load($where = array())
    {
        $model = Model::newInstance(get_class(), $where);
        return $model;
    }

}
?>