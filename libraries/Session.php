<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 8/7/13
 * Time: 11:14 AM
 * To change this template use File | Settings | File Templates.
 */

/**
 * Secure the session - Basic
 *
/* if(isset($_SESSION['HTTP_USER_AGENT']))
 {
     if($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
     {
         session_regenerate_id();
         $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
     }
 }
 else
 {
     $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
 }
 */

class Session
{

    const SETTING_AN_ARRAY = TRUE;

    const NO_PERSISTENT_STORAGE = FALSE;

    public static function init()
    {
        @session_start();
    }

    public static function set($key, $value, $array = false)
    {
        $_SESSION[$key] = $value;

        if ($array) {
            if (!isset($_SESSION[$key])) {
                $_SESSION[$key] = [];
                $_SESSION[$key][] = $value;
            }
        }
        else {
            $_SESSION[$key] = $value;
        }
    }

    public static function get($key, $persist = TRUE)
    {
        $return = NULL;
        if(isset($_SESSION[$key]))
        {
            $return = $_SESSION[$key];
            if (!$persist) unset($_SESSION[$key]);
        }

        return $return;

    }

    public static function seterror($error)
    {
        self::set('error', $error, self::SETTING_AN_ARRAY);
    }

    public static function destroy()
    {
        //empty the session array
        $_SESSION[] = [];

        //set session id to null or empty
        setcookie('PHPSESSID', '');

        //unset($_SESSION)
        session_destroy();
    }

}
