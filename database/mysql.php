<?php
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/2/13
 * Time: 2:34 PM
 * To change this template use File | Settings | File Templates.
 */

class mysql extends db implements singletoninterface
{
    protected static $instance = null;
    protected $link;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    protected function __construct()
    {
        $this->link = mysql_connect(DB_HOST, DB_USER, DB_PASS);
        mysql_select_db(DB_NAME, $this->link);
    }

    public function clean($string)
    {
        return mysql_real_escape_string($string, $this->link);
    }

    public function getArray($query)
    {
        $result = mysql_query($query, $this->link);

        $return = array();

        if ($result) {
            while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                $return[] = $row;
            }
        }

        return $return;
    }

    public function execute($query)
    {
        mysql_query($query, $this->link);
    }

    public function insertGetID($query)
    {
        $this->execute($query);
        return mysql_insert_id($this->link);
    }
}
