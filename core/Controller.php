<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 7/30/13
 * Time: 11:46 AM
 * To change this template use File | Settings | File Templates.
 */

class Controller
{

    function __construct()
    {
        /*echo "Main Controller <br>";*/

        //Create a new instance of the View class
        $this->view = new View();

        //Create a new instance of the Template class
        $this->template = new Template();

        //Create a new instance of the Validator class
        $this->validator = new Validator();

    }

    /**
     * @param $name Name of the model
     * @param string $modelPath location of the model
     */
    public function loadModel($name, $modelPath)
    {
        $path = $modelPath . $name.'_model.php';

        if(file_exists($path))
        {
            require $path;

            $modelName = $name.'_Model';

            $this->model = new $modelName();
        }
    }

}

?>
