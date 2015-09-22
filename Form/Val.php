<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 8/15/13
 * Time: 8:43 PM
 * To change this template use File | Settings | File Templates.
 */

class Val{

    public function __construct()
    {

    }

    public function minlength($data, $arg)
    {
        if(strlen($data) < $arg)
        {
            return "Your string cannot be less than $arg";
        }
    }

    public function maxlength($data, $arg)
    {
        if(strlen($data) > $arg)
        {
            return "Your string cannot be greater than $arg";
        }
    }

    public function integer($data)
    {
        if(!ctype_digit($data))
        {
            return "Your string must be a digit";
        }
    }

    public function __call($name, $arguments)
    {
        throw new Exception("$name does not exist inside of class ".__CLASS__);
    }
}
