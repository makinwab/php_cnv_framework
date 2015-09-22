<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 8/3/13
 * Time: 11:53 AM
 * To change this template use File | Settings | File Templates.
 */

class Datab extends PDO
{
    public function __construct($DB_TYPE,$DB_HOST,$DB_NAME,$DB_USER,$DB_PASS)
    {
        parent::__construct($DB_TYPE.':host='.$DB_HOST.';dbname='.$DB_NAME,$DB_USER,$DB_PASS);

        //parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTIONS);

    }

    /**
     * select
     * @param $sql An sql string
     * @param array $array Parameters to bind
     * @param $fetchMode A PDO fetch mode
     * @return array
     */

    public function select($sql, $array = [], $fetchMode = PDO::FETCH_ASSOC)
    {
        $stmt = $this->prepare($sql);
        //$stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach($array as $key => $value)
        {
            $stmt->bindValue(":$key",$value);
        }

        $stmt->execute();
        return $stmt->fetchAll($fetchMode);
    }

    /**
     * insert
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     */

    public function insert($table,$data)
    {
        ksort($data);

        $fieldNames= implode('`, `',array_keys($data));
        $fieldValues = ":".implode(', :',array_keys($data));

        $stmt = $this->prepare("INSERT INTO ".$table."(`$fieldNames`)
                                    VALUES ($fieldValues)");

        foreach($data as $key => $value)
        {
            $stmt->bindValue(':'.$key, $value);
        }

        $stmt->execute();
    }
    /**
     * update
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     * @param string $where the WHERE query part
     */
    public function update($table, $data, $where)
    {
        ksort($data);

        $fieldDetails = null;

        foreach($data as $key => $value)
        {
            $fieldDetails .= "$key = :$key,";
        }

        $fieldDetails = rtrim($fieldDetails,',');

        $stmt = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");

        foreach($data as $k => $v)
        {
            $stmt->bindValue(":$k",$v);
        }

        $stmt->execute();

    }

    /**
     * delete
     * @param string $table
     * @param string $where
     * @param int $limit
     * @return int Affected Rows
     */
    public function delete($table, $where, $limit = 1)
    {
       return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }
}
