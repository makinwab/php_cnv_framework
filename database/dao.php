<?php
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/2/13
 * Time: 1:31 PM
 * To change this template use File | Settings | File Templates.
 */

class dao{
    protected $values = [];

    public function __construct($qualifier = NULL)
    {
        if(!is_null($qualifier))
        {
            $conditional = [];
            $this->username = $qualifier;

            if(is_array($qualifier))
            {
                $conditional = $qualifier;
            }
            else
            {
                throw new Exception('Invalid type of qualifier given');
            }

        $this->populate($conditional);

        }

    }

    public function __set($name, $value)
    {
        $this->values[$name] = $value;
    }

    public function __get($name)
    {
        if(isset($this->values[$name]))
        {
            return $this->values[$name];
        }
        else
        {
            return null;
        }
    }

    public function populate($conditional)
    {
        $connection = db_factory::factory(DB_TYPE);

        $sql = "select * from {$this->table} where ";
        $qualifier = '';

        foreach ($conditional as $column=>$value) {
            if (!empty($qualifier)) {
                $qualifier .= ' and ';
            }
            $qualifier .= "`{$column}`='" . $connection->clean($value) . "' ";
        }

        $sql .= $qualifier;
        $valuearray = $connection->getArray($sql);
        if (!isset($valuearray[0])) {
            $valuearray[0] = array();
        }

        foreach ($valuearray[0] as $name=>$value) {
            $this->$name = $value;
        }
    }

    public function save()
    {
        if (!$this->id) {

            $this->create();
        }
        else {
        $this->update();
        }
    }

    protected function create()
    {
        $connection = db_factory::factory(DB_TYPE);

        $sql = "insert into {$this->table} (`";
        $sql .= implode('`, `', array_keys($this->values));
        $sql .= "`) values ('";

        $clean = array();
        foreach ($this->values as $value) {
            $clean[] = $connection->clean($value);
        }

        $sql .= implode("', '", $clean);
        $sql .= "')";

        $this->id = $connection->insertGetID($sql);
    }

    protected function update()
    {
        $connection = db_factory::factory(DB_TYPE);

        $sql = "update {$this->table} set ";

        $updates = array();
        foreach ($this->values as $key=>$value) {
            $updates[] = "`{$key}`='" . $connection->clean($value) . "'";
        }

        $sql .= implode(',', $updates);
        $sql .= "where id={$this->id}";

        $connection->execute($sql);
    }
}
