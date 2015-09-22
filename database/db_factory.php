<?php
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/2/13
 * Time: 2:27 PM
 * To change this template use File | Settings | File Templates.
 */

class db_factory{

    public static function factory($type)
    {
        return call_user_func([$type,'getInstance']);
    }
}
