<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 7/30/13
 * Time: 1:06 PM
 * To change this template use File | Settings | File Templates.
 */

class View{
    function __construct()
    {
        /*echo "This is the view <br>";*/
        //start output buffering
        ob_start();
    }


    /**
     * @param $name Name of the view file
     */
    public function render($name, $params = [])
    {
        $view = $params;
        ob_start();
        if(isset($view['header']))
        {
            require 'views/' . $view['header'] . '.php';
        }

        echo $name;
        if(isset($view['footer']))
        {
            require 'views/' . $view['footer'] . '.php';
        }

        $content = ob_get_clean();

        return $content;
    }

    public static function finish()
    {

        $content = ob_get_clean();

         return $content;
    }

}
