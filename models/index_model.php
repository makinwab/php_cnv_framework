<?php
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/3/13
 * Time: 12:32 PM
 * To change this template use File | Settings | File Templates.
 */
class Index_Model extends UserDao
{
    public function run($user,$pass)
    {
        $this->populate(['username'=>$user,'password'=>$pass]);

        if(!empty($this->values))
        {
            Session::init();
            Session::set('id',$this->id);
            Session::set('admin',$this->admin);
            $me = new UserDao();
            Session::set('user',$me);
            return true;
        }
        else
        {
            return false;
        }
    }
}
