<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 8/2/13
 * Time: 12:21 PM
 * To change this template use File | Settings | File Templates.
 */

class Model extends dao {
    function __construct()
    {
        $this->db = new dao();
    }
}
