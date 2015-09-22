<?php
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 10/24/13
 * Time: 3:34 PM
 * To change this template use File | Settings | File Templates.
 */

class error_lang{

    public $Lang = [];

    public function __construct()
    {
        $this->Lang['required']              = "The %s field is required";
        $this->Lang['isset']				 = "The %s field must have a value.";
        $this->Lang['valid_email']		     = "The %s field must contain a valid email address.";
        $this->Lang['valid_string']          = "The %s field must contain a string";
        $this->Lang['valid_emails']		     = "The %s field must contain all valid email addresses.";
        $this->Lang['valid_url']			 = "The %s field must contain a valid URL.";
        $this->Lang['valid_ip']			     = "The %s field must contain a valid IP.";
        $this->Lang['length_min']            = "The %s field must not be less %s characters";
        $this->Lang['length_max']            = "The %s field must not be greater than %s characters";
        $this->Lang['length_min_max']        = "The %s field must not be less than %s and greater than %s characters";
        $this->Lang['exact_length']          = "The %s field must be exactly %s character";
        $this->Lang['integer']			     = "The %s field must contain an integer.";
        $this->Lang['regex_match']		     = "The %s field is not in the correct format.";
        $this->Lang['matches']			     = "The %s field does not match the %s field.";
        $this->Lang['less_than']			 = "The %s field must contain a number less than %s.";
        $this->Lang['greater_than']		     = "The %s field must contain a number greater than %s.";
        $this->Lang['invalid_login']         = "Either your %s or %s is incorrect";
        $this->Lang['boolean']               = "The %s field must be a valid boolean";
    }
}

