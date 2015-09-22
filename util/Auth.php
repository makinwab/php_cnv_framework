<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 8/17/13
 * Time: 9:03 PM
 * To change this template use File | Settings | File Templates.
 */



class Auth {

    public static function handleLogin()
    {
        Session::init();
        $logged = Session::get('id');

        if(empty($logged))
        {
            Session::destroy();
            header('location:index');
            exit;
        }
    }

    public static function handleError()
    {
        $error = Session::get('error',Session::NO_PERSISTENT_STORAGE);
        if(empty($error))
        {
            $error = '';
        }

        return $error;
    }
}

