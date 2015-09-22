<?php
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/2/13
 * Time: 4:06 PM
 * To change this template use File | Settings | File Templates.
 */

class User_Model extends UserDao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createuser($user,$pass,$type)
    {

        $this->username = $user;
        $this->password = $pass;
        $this->admin = $type;
        if($this->save())
        {
            return "Registration Failed";
        }
        else
        {
            return "Registration Successful ";
        }

    }

    public function viewusers()
    {
        $usercoll = new userscollection(Session::get('user'));
        $usercoll->getwithdata();

        return $usercoll;
    }

    public function edit($user_id)
    {

        $this->populate(['id'=>$user_id]);

        return $this;

    }

    public function editsave($user_id,$user_data)
    {
        $this->populate(['id'=>$user_id]);
        $this->username = $user_data['username'];
        if($user_data['password'] != '')
        {
            $this->password = $user_data['password'];
        }
        $this->admin = $user_data['admin'];

        if($this->save())
        {
            return '<h4>Update Failed</h4>';
        }
        else
        {
            return '<h4>Update Successful</h4>';
        }

    }

    public function deleteuser($user_id)
    {
        $connection = db_factory::factory(DB_TYPE);
        $sql = "DELETE FROM $this->table WHERE id = $user_id";
        if($connection->execute($sql))
        {
            return "<h4>Delete Failed</h4>";
        }
        else
        {
            return "<h4>Delete Successful</h4> ";
        }


    }
}
