<?php

class Model
{
	
	private $modelName;

	private static $modelFields = array();

	private $update = FALSE;

	private $dirty = FALSE;

	public function __construct($modelName, $dependencies = array())
	{
		$this->modelName = $modelName;
		$this->dependencies = $dependencies;
		if(in_array($modelName, Model::$modelFields))
		{
			return;
		}
		$props = (new ReflectionClass(get_class($this)))
		$props = $props->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
		$fields = array();
		foreach($props as $prop)
		{
			if($prop->isStatic())
			{
				continue;
			}
			if(is_a($this->{$prop->getName()}, "Property"))
			{
				$fields[] = $prop->getName();
			}
		}
		Model::$modelFields[$modelName] = $fields;
	}

	private function initSQL()
	{
		$query = "CREATE TABLE IF NOT EXISTS " .DB_PREFIX.$this->modelName. "(";
		$fields = $this->getFields();
		$first = TRUE;
		foreach ($fields as $field) 
		{
			if(!$first)
				$query .= ",";
			else
				$first = FALSE;
			$query .= $this->$field->getSQL();
		}
		$query .= ")";
		$db = Database::getInstance();
		$db->exec($query);
	}

	public function get($property, $default = NULL)
	{
		if(!in_array($property, $this->getFields()))
		{
			Logger::log(Logger::WARNING, "Property $property doesn't exist in Model ".get_called_class());
			return $default;
		}
		$value = $this->$property->get();
		return isset($value) ? $value : $default;
	}

	public function set($property, $value)
	{
		if(!in_array($property, $this->getFields()))
		{
			Logger::log(Logger::WARNING, "Property $property doesn't exist in Model ".get_called_class());
			return;
		}
		$this->$property->set($value);
		$this->dirty = TRUE;
	}

	public function notDirty()
	{
		$this->dirty = FALSE;
	}

	public function isDirty()
	{
		return $this->dirty;
	}

	public function getFields()
	{
		return Model::$modelFields[$this->modelName];
	}

	public function save()
	{
		if(!$this->dirty)
		{
			return FALSE;
		}
		$db = Database::getInstance();
		$insert = array();
		$where = array();
		$onlyPrimary = FALSE;
		foreach($this->getFields() as $field)
		{
			$prop = $this->$field;
			if($prop->is_autoincrement()) 
			{
				if($prop->is_primary())
				{
					$onlyPrimary = TRUE;
				}
				continue;
			}

			if($prop->is_primary() || ($prop->is_unique() && !$onlyPrimary))
			{
				if($prop->is_primary() && !$onlyPrimary)
				{
					$onlyPrimary = TRUE;
					$where = array();
				}
				$where[$prop->getName()] = $prop->get();
				continue;
			}
			$insert[$prop->getName()] = $prop->get();
		}
		if($this->update)
		{
			if(!empty($insert) && !empty($where))
			{
				$db->update($this->modelName, $insert, $where);
			}
		}
		else
		{
			$db->insert($this->modelName, $insert);
		}
		return TRUE;
	}

	/**
	 *  Model loading helper method
	 */
	public static function newInstance($class, $where = array())
	{
		if($class == "Model")
		{
			throw new Exception("Cannot instantiate the Model base: the static load method has to be invoked from a subclass (called from $class)");
		}
		if($where)
		{
			return Model::_load($where, $class);
		}
		return new $class;
	}

	public static function load($where = array())
	{
		return Model::_load($where, get_called_class());
	}

	public static function _load($where = array(), $class)
	{
		$db = Database::getInstance();
		$obj = new $class();
		$rows = $db->select($obj->modelName, $where);
		if(!$rows || !is_array($rows))
		{
			return FALSE;
		}
		if(isset($rows[0]) && count($rows[0]) > 0)
		{
			$rows = $rows[0];
		}
		$obj->update = TRUE;
		foreach($obj->getFields() as $field)
		{
			$prop = $obj->$field;
			$prop->set($rows[$prop->getName()]);
		}
		return $obj;
	}

	public function delete($where = array())
	{
		$db = Database::getInstance();
		$db->delete($this->modelName, $where);
	}

	public static function init()
	{
		$class = get_called_class();
		$class = new $class;
		// TODO: fix loading order!
		$class->initSQL();
	}

}

class Property
{

	private $name;

	private $primary = FALSE;

	private $unique = FALSE;

	private $autoIncrement = FALSE;

	private $reference;

	private $value = NULL;

	private $SQLType = NULL;

	private $SQLLength = 0;

	public function __construct($name = NULL, $SQLType = "VARCHAR", $SQLLength = 0, $default = NULL)
	{
		if(empty($name))
		{
			throw new Exception("Property name cannot be null");
		}
		$this->name = $name;
		$this->SQLType = $SQLType;
		$this->SQLLength = $SQLLength;
		$this->value = $default;
	}

	public function getName()
	{
		return $this->name;
	}

	public function get()
	{
		return $this->value;
	}

	public function set($value)
	{
		$this->value = $value;
	}

	public function primary($value = TRUE)
	{
		$this->primary = $value;
		return $this;
	}

	public function is_primary()
	{
		return $this->primary;
	}

	public function unique($value = TRUE)
	{
		$this->unique = $value;
		return $this;
	}	

	public function is_unique()
	{
		return $this->unique;
	}

	public function autoIncrement($value = TRUE)
	{
		$this->autoIncrement = $value;
		return $this;
	}

	public function is_autoincrement()
	{
		return $this->autoIncrement;
	}

	public function refers($table, $column)
	{
		$this->reference = new Reference($table, $column);
		return $this;
	}

	public function getSQL()
	{
		$sql = $this->name ." ". (!empty($this->SQLType) ? $this->SQLType : "VARCHAR");
		if(is_int($this->SQLLength) && $this->SQLLength > 0)
		{
			$sql = "$sql(".$this->SQLLength.")";
		}
		if($this->primary)
		{
			$sql .= " PRIMARY KEY";
		}
		if($this->unique)
		{
			$sql .= " UNIQUE";
		}
		if($this->autoIncrement)
		{
			$sql .= " AUTO_INCREMENT";
		}
		if($this->reference)
		{
			$sql .= ", FOREIGN KEY(".$this->name.") ".$this->reference->getSQL()." ON DELETE CASCADE";
		}
		return $sql;
	}
}

class Reference
{
	private $table;

	private $column;

	public function __construct($table, $column)
	{
		if(empty($table) || empty($column))
		{
			throw new Exception("Table and/or column was empty in reference");
		}
		$this->table = $table;
		$this->column = $column;
	}

	public function getSQL()
	{
		return "REFERENCES ".DB_PREFIX."{$this->table}({$this->column})";
	}
}

$models = array_diff(scandir(INCDIR."/models"), array(".", ".."));
foreach ($models as $model) 
{
	$classes = Utils::loadClasses($models, INCDIR . '/models', "Model");
	foreach($classes as $class)
	{
		$rc = new ReflectionClass($class);
		if($rc->isAbstract())
		{
			continue;
		}
		$class::init();
	}
}

?>