<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 7/30/13
 * Time: 11:39 AM
 * To change this template use File | Settings | File Templates.
 */

class Error extends Controller{
    function __construct()
    {
        parent::__construct();
        /*$this->newerr = "An Error was encountered please contact your administrator for help!!! <br>";*/
    }

    function index()
    {
        $this->template->template_file = 'error/index';
        $this->template->entries[] = (object)['title' => '404 error', 'message' => "The page does not exist"];
        $name = $this->template->generate_markup();
        $inc = ['header'=>'error/inc/header','footer'=>'error/inc/footer'];
        echo $this->view->render($name,$inc);
    }
}
