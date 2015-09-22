<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Makinwab
 * Date: 8/15/13
 * Time: 1:01 PM
 * To change this template use File | Settings | File Templates.
 */

/**
 * - Fill out a form
 * - Post to PHP
 * - Sanitize
 * - Validate
 * - Return Data
 * - Write to Database
 */
require 'Form/Val.php';
class Form {

    /** @var null $_currentItem The immediately posted item */
    private $_currentItem = null;

    /** @var array $_postData Stores the posted data */
    private $_postData = [];

    /** @var array $_val The validator object */
    private $_val = [];

    /** @var array $_error Holds the current forms errors */
    private $_error = [];

    /**
     * ____construct - Instantiates the validator class
     */
    public function __construct()
    {
        $this->_val = new Val();
    }

    /**
     * post - This is to run $_POST
     * @param $field
     * @return object
     */
    public function post($field)
    {
        $this->_postData[$field] = $_POST[$field];
        $this->_currentItem = $field;
        return $this;
    }

    /**
     * fetch - Return the posted data
     *
     * @param bool $fieldName
     * @return array
     */
    public function fetch($fieldName = false)
    {
        if($fieldName)
        {
            if(isset($this->_postData[$fieldName]))
            {
                return $this->_postData[$fieldName];
            }
            else
            {
                return false;
            }

        }
        else
        {
            return $this->_postData;
        }
    }

    /**
     * val - This is to validate
     *
     * @param string $typeofvalidator A method from he Form/Val class
     * @param string $arg A property to validate against
     * @return $this
     */
    public function val($typeofvalidator, $arg = null)
    {
        if($arg == null)
        {
            $error = $this->_val->{$typeofvalidator}($this->_postData[$this->_currentItem]);
        }
        else
        {
            $error = $this->_val->{$typeofvalidator}($this->_postData[$this->_currentItem], $arg);
        }


        if($error)
        {
            $this->_error[$this->_currentItem] = $error;
        }

        return $this;
    }

    /**
     * submit - Handles the form and throws an exception upon error
     * @return bool
     * @throws Exception
     */
    public function submit()
    {
        if(empty($this->_error))
        {
            return true;
        }
        else
        {
            $str = '';
            foreach($this->_error as $key => $value)
            {
                $str .= $key .'=>'.$value ."\n";
            }
            throw new Exception($str);
        }
    }
}
