<?php
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/2/13
 * Time: 1:11 PM
 * To change this template use File | Settings | File Templates.
 */

class Index extends Controller
{
    public function __construct()
    {
        parent::__construct();

        //Set the testing template file location
        $this->template->template_file = 'index/index';
    }

   public function index()
    {

        if(array_key_exists('login',$_POST))
        {
            $required = ["username","password"];
            $rules = ["username"=>"cleanString","password"=>"cleanString"];

            $this->validator->boot($required);
            $this->validator->validateField($rules,false);

            $missing = $this->validator->getMissing();
            $errors = $this->validator->getErrors();
            $filtered = $this->validator->getFiltered();

            if(!empty($missing))
            {
                $miss = "";
                if(is_array($missing))
                {
                    foreach($missing as $value)
                    {
                       $miss .= sprintf($this->validator->_error_lang->Lang['required'],$value) ."<br>";
                    }
                }

                Session::seterror($miss);
            }
            else if(!empty($errors))
            {
                $err = "The following errors occurred: <br>";
                if(is_array($errors))
                {

                    foreach($errors as $value)
                    {
                        $err .= $value ."<br>";
                    }
                }

                Session::seterror($err);
            }
            else
            {
                $username = $_POST['username'];
                $password = $_POST['password'];


                $this->ret = $this->run($username,$password);

                if($this->ret)
                {
                    header("location:".URL."user");
                }
                else
                {
                    $error_message = sprintf($this->validator->_error_lang->Lang['invalid_login'],"username","password");
                    Session::seterror($error_message);
                }

            }

        }

        $error = Auth::handleError();

        $this->template->entries[] = (object)['test' => 'working','link' => URL.'index', 'error' => $error];
        $name = $this->template->generate_markup();
        $inc_s = ['header'=>'header', 'footer'=>'footer'];
        echo $this->view->render($name);

    }

    function run($user,$pass)
    {
        return $this->model->run($user,$pass);
    }


}
