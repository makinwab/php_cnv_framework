<?php
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/2/13
 * Time: 2:24 PM
 * To change this template use File | Settings | File Templates.
 */

abstract class db
{
    abstract public function execute($query);
    abstract public function getArray($query);
    abstract public function insertGetID($query);
    abstract public function clean($string);
}
