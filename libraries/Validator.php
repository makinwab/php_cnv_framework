<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Swap Space Systems
 * Date: 4/27/13
 * Time: 10:57 AM
 * To change this template use File | Settings | File Templates.
 */
class Validator
{
    protected $_missing;
    protected $_submitted;
    protected $_required;
    public $_filtered;
    protected $_errors;
    protected $_input_type;
    public  $_optional;
    public $_checked_optional;
    public $_error_lang;

    /**
     * constructor: creates an instance of the error lang class and makes it available for properties that need it.
     */
    public function __construct()
    {
        $this->_error_lang = new error_lang();
    }

    /**
     * boot : boots the validator class by housing the entire form field and allocating them to their spaces either required or optional
     *
     * @param array $required
     * @param array $optional
     * @param string $inputType
     * @throws Exception
     */
    public function boot($required=[], $optional=[], $inputType='post')
    {
        // check if required is array...
        if(!is_array($required)) throw new Exception("required must be an array");

        $this->_required = $required; // collects required form elements
        $this->setInputType($inputType); // set the input type, $_POST or $_GET

        if(! empty($optional))
        {
            if(is_array($optional) )
            {
                $this->_optional = $optional;

                // check for true optional fields
                $this->checkOptional();
            }
            else
            {
                throw new Exception("optional must be an array and must not be empty");
            }
        }

        if(!empty($this->_required))
        {
            $this->_filtered = array();
            $this->_errors = array();
            $this->checkRequired();
        }
    }

    /*
     * ValidateFields
     *
     *
     * @access	public
     * @param	mixed
     * @return	void
     */
    public function validateField($fieldName, $optional, $methods = "")
    {
        // check if parameter $fieldname is an array, if its
        // an array, we split it into its components and run
        // validateField funciton on it recursively.
        if( is_array($fieldName))
        {
            // is it optional? if its optional
            // select the keys that have true values..
            if($optional === true)
            {
                // get the difference between the $fieldname array
                // and the $optional array

                /*$diff = array_diff_key($fieldName, $this->_checked_optional);*/
                $diff = $this->_checked_optional;

                // loop through...
                foreach( $diff as $key => $val)
                {
                    if(empty($val))
                    {
                        if(array_key_exists($key, $fieldName))
                            unset($fieldName[$key]);
                    }

                }

            }


            foreach($fieldName as $field => $m)
            {
                // if the field has no value, skip
                if( empty($m) )
                    continue;

                // recall the method
                $this->validateField($field, $optional, $m);
            }
        }

        // separate all method passed and return
        // it as an array
        $funcs = explode('|', $methods);

        // loop through the methods and part their names
        // from their arguments. E.g sum(0,2) becomes an
        // array of [sum, [0,2]

        foreach($funcs as $key => $f)
        {

            // get method name
            $methodName = $this->splitMethod($f)[0];

            // store array of args temporarily and
            $a_temp = $this->splitMethod($f)[1];

            // place the field name first in the array of args
            // and collect into a new variable.
            array_unshift($a_temp, $fieldName);
            $args = $a_temp;

            if(method_exists($this, $methodName))
            {
                call_user_func_array([$this, $methodName], $args);
            }
        }
    }   // END of validateFields


    /**
     * getFiltered : returns the filtered fields
     *
     * @return array
     *
     */
    public function getFiltered()
    {
        $new_filtered = array_diff_key($this->_filtered,$this->_errors);
        return $new_filtered;
    }

    /**
     * getMissing : returns the missing fields
     *
     * @return mixed
     */
    public function getMissing()
    {
        return $this->_missing;
    }

    /**
     * getErrors : returns errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->_errors;
    }

    /**
     * splitMethod : splits a string into methods and parameters
     *
     * @access  protected
     * @param   string
     * @return  array
     */
    protected function splitMethod($str)
    {
        // if the string contains a bracket '('
        // pick every character starting from the
        // first bracket and store it in args
        $args = strstr($str, '(');

        // if args is false, return an array with a trimmed str and an empty []
        // else return a trimmed str with an array of arguments
        return ($args === false) ? [trim($str), []] : [trim(str_replace($args, ' ', $str)), explode(',',substr($args, 1, -1))];

    }

    /**
     * setInputType : sets the method used to send the forms' data
     *
     * @param $type
     */
    protected function setInputType($type)
    {
        switch(strtolower($type))
        {
            case 'post':

                $this->_submitted = $_POST;
            case 'get':
                $this->_submitted = $_GET;
            default:
                $this->_submitted = $_POST;
        }
    }

    /**
     * checkRequired : checks if a fields' value is required
     */
    protected function checkRequired()
    {
        $OK = array(); // array to hold fields that pass the test

        // loop through the submitted array...
        foreach($this->_submitted as $key => $val )
        {
            // trim for white spaces
            $value = (is_array($val)) ? $val : trim($val);

            if(!empty($value))
            {
                // store the key
                $OK[] = $key;
            }
        }

        // put missing elements in missing array.
        $this->_missing = array_diff($this->_required, $OK);

    }


    /**
     * checkOptional : checks if a fields' value is optional
     */
    protected function checkOptional()
    {
        // loop through the submitted array...
        foreach($this->_optional as $key => $val )
        {
            if( array_key_exists($val, $this->_submitted) && !empty($this->_submitted[$val]) && !is_null($this->_submitted[$val]))
            {
                $this->_checked_optional[$val] = $this->_submitted[$val];
            }
            else
            {
                $this->_checked_optional[$val] = "";

            }
        }
    }

    /**
     * cleanString : sanitizes a fields' string value
     *
     * @param $fieldName
     * @param null $min
     * @param null $max
     */
    protected function cleanString($fieldName,$min = null,$max=null)
    {
        $this->checkArray($fieldName,'cleanString');

            if(filter_var($this->_submitted[$fieldName],FILTER_SANITIZE_STRING))
            {
                if(! is_null($min) || ! is_null($max))
                {
                    $this->checkLength($fieldName,$min,$max);
                }
                else
                {
                    $this->_filtered[$fieldName] = filter_var($this->_submitted[$fieldName],FILTER_SANITIZE_SPECIAL_CHARS);

                }
            }
            else
            {
                $this->_errors[$fieldName] = sprintf($this->_error_lang->Lang['valid_string'],$fieldName);

            }

    }

    /**
     * isInt : validates a fields' integer value
     *
     * @param $fieldName
     * @param null $min
     * @param null $max
     */
    protected function isInt($fieldName, $min=null, $max=null)
    {
        $this->checkArray($fieldName,'isInt');

        $options = [];

        if(is_numeric($min))
            $options['options']['min_range'] = $min;


        if(is_numeric($max))
            $options['options']['max_range'] = $max;

        /*$options = ["options" => ["min_range" => $min_range,"max_range" => $max_range]];*/

        if(is_null($min) && is_null($max))
        {
            $options = "";
        }

        if(! filter_var($this->_submitted[$fieldName],FILTER_VALIDATE_INT, $options))
        {
            $this->_errors[$fieldName] = sprintf($this->_error_lang->Lang['integer'],$fieldName);
        }
        else
        {
            $this->_filtered[$fieldName] = $this->_submitted[$fieldName];

        }
    }

    /**
     * isBool : validates a fields' boolean value
     *
     * @param $fieldName
     */
    protected function isBool($fieldName)
    {
        $this->checkArray($fieldName,'isBool');

        if(! filter_var($this->_submitted[$fieldName],FILTER_VALIDATE_BOOLEAN))
        {
            $this->_errors[$fieldName] = sprintf($this->_error_lang->Lang['boolean'],$fieldName);
        }
        else
        {
            $this->_filtered[$fieldName] = $this->_submitted[$fieldName];

        }
    }

    /**
     * isEmail : validates an email
     *
     * @param $fieldName
     */
    protected function isEmail($fieldName)
    {
        $this->checkArray($fieldName,'isEmail');
        if(! filter_var($this->_submitted[$fieldName],FILTER_VALIDATE_EMAIL))
        {
            $this->_errors[$fieldName] = sprintf($this->_error_lang->Lang['valid_email'],$fieldName);
        }
        else
        {
            /*filter_var($this->_submitted[$fieldName], FILTER_SANITIZE_EMAIL);*/
            $this->_filtered[$fieldName] = $this->_submitted[$fieldName];

        }
    }

    /**
     * checkLength : checks the length of a fields' string value
     *
     * @param $fieldName
     * @param $min
     * @param $max
     */
    protected function checkLength($fieldName,$min,$max)
    {
       if(strlen($this->_submitted[$fieldName]) >= intval($min) && strlen($this->_submitted[$fieldName]) <= intval($max))
       {
            $this->_filtered[$fieldName] = filter_var($this->_submitted[$fieldName],FILTER_SANITIZE_SPECIAL_CHARS);
           echo $this->_filtered[$fieldName];
       }
       else
       {
            $this->_errors[$fieldName] = sprintf($this->_error_lang->Lang['length_min_max'],$fieldName,$min,$max);
       }
    }

    /**
     * checkArray : checks if a fields' value is an array
     *
     * @param $fieldName
     * @param $meth
     */
    protected function checkArray($fieldName, $meth)
    {
        if(is_array($this->_submitted[$fieldName]))
        {
            foreach($this->_submitted[$fieldName] as $key => $value)
            {
                 call_user_func([$this, $meth], $key);
            }
        }

    }

   /* public function assignField($fieldName)
    {
        if(! $this->checkArray($fieldName))
        {
            $field = $this->_submitted[$fieldName];

        }
        else
        {

            $field = $this->checkArray($fieldName);

        }
        return $field;
    }*/





}

?>



