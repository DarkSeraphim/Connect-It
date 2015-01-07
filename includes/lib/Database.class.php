<?php

class Database
{
    private static $instance;

    private $connection;

    // TODO: implement query cache
    private $cache;

    private function __construct()
    {
    }

    private function initialize()
    {
        // TODO: convert to OO
        $this->connection = new mysqli(DB_HOST . ":" . DB_PORT, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        if($this->connection->connect_errno)
        {
            // If we can do this?
            throw new Exception("Failed to connect to the MySQL database (". $this->connection->connect_errno ."): ".$this->connection->connect_error);
        }
    }

    public static function getInstance()
    {
        if(!isset(self::$instance))
        {
            self::$instance = new Database();
            self::$instance->initialize();
        }
        return self::$instance;
    }

    public function select($table, $where = array(), $order = "ASC", $limit, $offset = 0)
    {
        if(!$table)
        {
            throw new Exception("Table required");
        }
        if(is_array($table))
        {
            $t = "";
            foreach($table as $tbl)
            {
                if($t != "")
                {
                    $t .= ",";
                }
                $t .= DB_PREFIX.$tbl;
            }
            $table = $t;
        }
        else 
        {
            $table = DB_PREFIX.$table;
        }

        $w = "";
        foreach($where as $k => $v)
        {
            if($w != "")
            {
                $w .= " AND ";
            }
            if(is_numeric($v))
            {
                $w .= "$k = $v";
            }
            else
            {
                $w .= "$k = '$v'";
            }
        }

        $l = "";
        if($limit)
        {
            if(!$offset)
            {
                $offset = 0;
            }
            $l = "LIMIT $offset, $limit";
        }
        return $this->exec("SELECT * FROM ". $table . " WHERE $w $order $l");
    }

    public function insert($table, $insert)
    {
        if(!$table)
        {
            throw new Exception("Table required");
        }
        if(is_array($table))
        {
            throw new Exception("Single table required (string expected)");
        }
        else 
        {
            $table = DB_PREFIX.$table;
        }

        $fieldList = array();
        $valueList = array();
        foreach($insert as $k => $v)
        {
            $fieldList[] = "`$k`";
            if(is_numeric($v))
            {
                $valueList[] = "$v";
            }
            else
            {
                $valueList[] = "'$v'";
            }
        }

        $fieldList = join($fieldList, ",");
        $valueList = join($valueList, ",");
        
        return $this->exec("INSERT INTO `". $table . "`($fieldList) VALUES($valueList)");   
    }

    public function update($table, $insert, $where)
    {
        if(!$table)
        {
            throw new Exception("Table required");
        }
        if(is_array($table))
        {
            throw new Exception("Single table required (string expected)");
        }
        else 
        {
            $table = DB_PREFIX.$table;
        }

        $valueList = array();
        foreach($insert as $k => $v)
        {
            if(is_numeric($v))
            {
                $valueList[] = "`$k` = $v";
            }
            else
            {
                $valueList[] = "`$k` = '$v'";
            }
        }
        $valueList = join($valueList, ",");

        $w = "";
        foreach($where as $k => $v)
        {
            if($w != "")
            {
                $w .= " AND ";
            }
            if(is_numeric($v))
            {
                $w .= "$k = $v";
            }
            else
            {
                $w .= "$k = '$v'";
            }
        }
        
        return $this->exec("UPDATE `". $table . "` SET $valueList WHERE $w");   
    }

    public function delete($table, $where)
    {
        if(!$table)
        {
            throw new Exception("Table required");
        }
        if(is_array($table))
        {
            throw new Exception("Single table required (string expected)");
        }
        else 
        {
            $table = DB_PREFIX.$table;
        }

        $w = "";
        foreach($where as $k => $v)
        {
            if($w != "")
            {
                $w .= " AND ";
            }
            if(is_numeric($v))
            {
                $w .= "$k = $v";
            }
            else
            {
                $w .= "$k = '$v'";
            }
        }
        return $this->exec("DELETE FROM ". $table . " WHERE $w");   
    }

    public function exec($query)
    {
        if(!$this->connection->real_query($query))
        {
            Logger::log(Logger::SEVERE, "An MySQL exception occurred (". $this->connection->errno ."): ".$this->connection->error);
            return FALSE;
        }
        if($this->connection->field_count === 0)
        {
            return TRUE;
        }
        $result = $this->connection->use_result();
        if(!$result)
        {
            Logger::log(Logger::SEVERE, "An MySQL exception occurred (". $this->connection->errno ."): ".$this->connection->error);
            return FALSE;
        }
        $return = array();
        while($row = $result->fetch_assoc())
        {
            $return[] = $row;
        }
        return $return;
    }

}

?>