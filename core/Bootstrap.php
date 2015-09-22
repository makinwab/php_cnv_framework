<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 7/30/13
 * Time: 11:32 AM
 * To change this template use File | Settings | File Templates.
 */

class Bootstrap{

    private $_url = null;
    private $_controller = null;
    private $_params = null;
    private $_parts = null;

    private $_controllerPath = 'controllers/'; // Always include trailing slash
    private $_modelPath = 'models/'; // Always include trailing slash
    private $_errorFile = 'error.php';
    private $_defaultFile = 'index.php';


    /**
     * Starts the Bootstrap
     *
     * @return boolean
     */
    public function init()
    {
        // Sets the protected $_url
        $this->_getUrl();

        // Load the default controller if no URL is set
        // eg: Visit http://localhost/CNV_Framework it loads Default Controller
        if (empty($this->_url[0])) {
            $this->_loadDefaultController();
            return false;
        }

        $this->_loadExistingController();
        $this->_callControllerMethod();

        $content =  $this->_controller->view->finish();
        echo $content;

    }

    /**
     * (Optional) Set a custom path to controllers
     * @param string $path
     */
    public function setControllerPath($path)
    {
        $this->_controllerPath = trim($path, '/') . '/';
    }

    /**
     * (Optional) Set a custom path to models
     * @param string $path
     */
    public function setModelPath($path)
    {
        $this->_modelPath = trim($path, '/') . '/';
    }

    /**
     * (Optional) Set a custom path to the error file
     * @param string $path Use the file name of your controller, eg: error.php
     */
    public function setErrorFile($path)
    {
        $this->_errorFile = trim($path, '/');
    }

    /**
     * (Optional) Set a custom path to the error file
     * @param string $path Use the file name of your controller, eg: index.php
     */
    public function setDefaultFile($path)
    {
        $this->_defaultFile = trim($path, '/');
    }

    /**
     * Fetches the $_GET from 'url'
     */
    private function _getUrl()
    {
        $url = isset($_GET['url'])? $_GET['url'] : null;
        $url = rtrim($url,'/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/',$url);
    }

    /**
     * This loads if there is no GET parameter passed
     */
    private function _loadDefaultController()
    {
        require_once $this->_controllerPath.$this->_defaultFile;
        $this->_controller = new Index();
        $this->_controller->index();

    }

    /**
     * Load an existing controller if there IS a GET parameter passed
     *
     * @return boolean|string
     */
    private function _loadExistingController()
    {
        $file = $this->_controllerPath.$this->_url[0].'.php';

        if(file_exists($file))
        {
            require_once $file;
            $this->_controller = new $this->_url[0];
            $this->_controller->loadModel($this->_url[0], $this->_modelPath);
        }
        else
        {
            $this->_error();
            return false;
        }
    }

    /**
     * call a controllers' method
     *
     * @return bool
     * @throws ActionFailedException
     * @throws SectionDoesntExistException
     */
    private function _callControllerMethod()
    {
        $this->_parts = $this->_url;
        array_shift($this->_parts);
        array_shift($this->_parts);
        $this->_params = $this->_parts;


            if (!class_exists($this->_url[0])) {
                throw new SectionDoesntExistException("{$this->_url[0]} is not a valid module.");
            }

            $length = count($this->_url);

            // Make sure the method we are calling exists
            if ($length > 1) {
                if (!method_exists($this->_controller, $this->_url[1])) {
                    //throw new ActionDoesntExistException("{$this->_url[1]} of module {$this->_url[0]} is not a valid action.");
                    $this->_error();
                }

            }

            if($length == 1)
            {
                $this->_controller->index();
                return false;
            }

            $called = call_user_func_array([$this->_controller, $this->_url[1]], $this->_params);

            if ($called === FALSE) {
                throw new ActionFailedException("{$this->_url[1]} of section {$this->_url[0]} failed to execute properly.");
            }

    }

    /**
     * Display an error page if nothing exists
     *
     * @return boolean
     */
    private function _error() {
        require $this->_controllerPath . $this->_errorFile;
        $this->_controller = new Error();
        $this->_controller->index();
        exit;
    }
}
