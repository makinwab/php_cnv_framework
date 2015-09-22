<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 7/30/13
 * Time: 10:20 AM
 * To change this template use File | Settings | File Templates.
 */


//configuration file
require_once 'config.php';

//using spl autoloader
require_once 'libraries/autoloader.php';

//exceptions file
require_once 'core/exceptions.php';

    // Load the Bootstrap!
    $bootstrap = new Bootstrap();

    // Optional Path Settings
    $bootstrap->setControllerPath('controllers/');
    //$bootstrap->setModelPath();
    //$bootstrap->setDefaultFile();
    //$bootstrap->setErrorFile();

    $bootstrap->init();
   /*$content = $bootstrap->init();
    echo $content;*/
?>

