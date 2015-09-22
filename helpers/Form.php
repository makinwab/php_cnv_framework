
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pguto
 * Date: 06/07/13
 * Time: 16:00
 * To change this template use File | Settings | File Templates.
 */

class Form {

    /* constructor
    *
     * creates a formatted form tag [ <form]; {public}
     *
     * Params description:
     * $attr   - this is the attribute of the form  tag [<form action="me.php" method="post"  name="name" id="id">] it has to be associative
     *
     * *******HOW TO USE******
     * create an array
     *  eg....$attr=[action=>"me.php" method=>"post" "name"=>"name",]
     *>>>>>PASS IT INTO THE CONSTRUCTOR>>>>>>>>
     * $me=new Form($attr);
     * Returns:
     * Formatted form element
     * <<<<<<<note the constructor only returns dis<<<<<
     * <form action="me.php" method="post"  name="name" id="id">; (string)
    */
    public function __construct($attr=[])
    {
         $form='<form';
        if(!empty($attr))
        {
            foreach($attr as $key =>  $val)

            {
                $form.= ' '.$key.'='.$val;
            }
          $form.='>';
        }
        else
        {
            $form.='>';
        }
        echo $form;

    }

    /* inputType
    *
     * creates a formatted input tag [ <input]; {public}
     *
     * Params description:
     * $attr   - this is the attribute of the input  tag [<input type=>"text"|"password"  name="name" id="id">] it has to be associative
     *
     * *******HOW TO USE******
     *   1...create 2 arrays
     * i...the attributes array
     *   eg....$attr=["type"=>"text" ,"name"=>"name",]
     * ii...the value array which is only applicable in the case of a radio button
     *  eg....$sex=array("male","female");
     *>>>>>PASS IT INTO THE inputType method>>>>>>>>
     * $me->inputType($attr,$sex);
     * Returns:
     * Formatted input tag element
     *
     * <input type=>"text"|"password"  name="name" id="id">; (string)
    */
    public function inputType($attr=[],$inputVal=[])
    {
        //check if the inputVal array is not empty
        if(!empty($inputVal))
        {
            //if its not empty loop through the inputVal array
            foreach($inputVal as $data=>$value)
            {
                echo $value;
                //assign the opening tag of the input tag to input <input
                $input='<input ';
                //append the value to the input tag
                $input.='value='.$value;
                    foreach($attr as $key =>  $val)
                    {
                        //append the attributes in the array to the input tag
                        $input.= ' '.$key.'='.$val;

                    }
                        //close the input tag
                    $input.='>';
                echo $input;
            }

        }
        //if the inputVal is empty
        else
        {
            //assign the opening tag of the input tag to input <input
            $input='<input ';
            //check if the attribute array is not empty
            if(!empty($attr))
            {
                //loop through the array
                foreach($attr as $key => $val)
                {
                    //append the attributes in the array to the input tag
                    $input.= ' '.$key.'='.$val;
                }
                $input.='>';
            }
            else
            {
                $input.='>';
            }
            echo $input;
        }


    }

    /* checkBox
    *
     * creates a formatted input check box tag [ <input type =>"check"]; {public}
     *
     * Params description:
     * $attr   - this is the attribute of the input  tag [<input type=>"text"|"password"  name="name" id="id">] it has to be associative
     *
     * *******HOW TO USE******
     *   1...create  array
     * i...the inputVal  array as a multidimensional arrsy
     *   eg....$hobbies=["dancing"=>["name"=>"dancing","swimming"=>"swimming]
     *
     *>>>>>PASS IT INTO THE inputType method>>>>>>>>
     * $me->checkBox($hobbies);
     * Returns:
     * Formatted input checkbox tag element
     *
     * <input type=>"checkbox"  name="name" id="id">; (string)
    */
    public function checkBox($inputVal=[])
    {
        //check if the inputVal array is empty or not
        if(!empty($inputVal))
        {
            //loop through the inputVal array
            foreach($inputVal as $data=>$attr)
            {
                echo $data;
                //check if the attr value is an array
                if(is_array($attr))
                {

                    //append the default attribute to it
                    $input='<input type="checkbox"';


                    //loop through the attr array
                    foreach($attr as $key =>  $val)

                    {

                        $input.= ' '.$key.'='.$val;

                    }
                    //close the input tag [<input type=>"checkbox"  name="name" id="id">]
                    $input.='>';
                }
                else
                {
                    $input='<input ';
                }
                echo $input;
            }



        }


    }


    /* textArea
   *
    * creates a formatted input check box tag [ <input type =>"check"]; {public}
    *
    * Params description:
    * $attr   - this is the attribute of the input  tag [<input type=>"text"|"password"  name="name" id="id">] it has to be associative
    *
    * *******HOW TO USE******
    *   1...create  array
    * i...the inputVal  array as a multidimensional arrsy
    *   eg....$hobbies=["dancing"=>["name"=>"dancing","swimming"=>"swimming]
    *
    *>>>>>PASS IT INTO THE inputType method>>>>>>>>
    * $me->checkBox($hobbies);
    * Returns:
    * Formatted input checkbox tag element
    *
    * <input type=>"checkbox"  name="name" id="id">; (string)
   */
    public function createTextArea($name="",$id="")
    {
    $this->_name=$name;
    $this->_id=$id;
?>
        <textarea name="<?php echo $this->_name; ?>" id="<?php echo $this->_id; ?>">
<?php

    }

    /* closeTag
   *
    * creates a formatted input check box tag [ <input type =>"check"]; {public}
    *
    * Params description:
    * $attr   - this is the attribute of the input  tag [<input type=>"text"|"password"  name="name" id="id">] it has to be associative
    *
    * *******HOW TO USE******
    *   1...create  array
    * i...the inputVal  array as a multidimensional arrsy
    *   eg....$hobbies=["dancing"=>["name"=>"dancing","swimming"=>"swimming]
    *
    *>>>>>PASS IT INTO THE inputType method>>>>>>>>
    * $me->checkBox($hobbies);
    * Returns:
    * Formatted input checkbox tag element
    *
    * <input type=>"checkbox"  name="name" id="id">; (string)
   */
    public function closeTag($tagName)
    {
?>
        </<?php echo $tagName;?>>
<?php
    }

    /* label
   *
    * creates a formatted input check box tag [ <input type =>"check"]; {public}
    *
    * Params description:
    * $attr   - this is the attribute of the input  tag [<input type=>"text"|"password"  name="name" id="id">] it has to be associative
    *
    * *******HOW TO USE******
    *   1...create  array
    * i...the inputVal  array as a multidimensional arrsy
    *   eg....$hobbies=["dancing"=>["name"=>"dancing","swimming"=>"swimming]
    *
    *>>>>>PASS IT INTO THE inputType method>>>>>>>>
    * $me->checkBox($hobbies);
    * Returns:
    * Formatted input checkbox tag element
    *
    * <input type=>"checkbox"  name="name" id="id">; (string)
   */

    public function label($id)
    {
        $this->_id=$id
?>
        <label for="<?php echo $this->_id; ?>">
<?php
    }


    /* select
    *
     * creates a formatted select tag [ <select> ]; {public}
     *
     * Params description:
     * $selAttr   - this is the attribute of the select tag [<select  name="name" id="id">] it has to be associative
     * eg::$selAttr=["name"=>"name"]
     * $optAttr   - this is the attribute of the option tag [<option id="id">]  it has to be associative
     * eg::$optAttr=["name"=>"name"]
     *  $optVal   - this is the value  in an option tag [<option>....</option>]
     * Returns:
     * Formatted select element with the option tag appended to it
     * <select> <option></option> </select> ; (string)
    */
    public function select($selAttr=[],$optAtr=[],$optVal=[])
    {
        //opens a select tag
        $select='<select';

        //check if the select attribute is empty or not
        if(!empty($selAttr))
        {
            foreach($selAttr as $selattr=>$selvalue)
            {
                //attach each atrribute to the  select tag
                $select.= ' '. $selattr.'='.$selvalue;
            }
            //close the  select tag
            $select.='>';
        }
        else
        {
            //close the select tag
            $select.='>';
        }
        //chech if the option value is empty or not
        if(!empty($optVal))
        {

            foreach($optVal as $val)
            {
                //attach the option tag to the select tag
                $select.='<option ';
                //check if the option attribute is empty or not
                if(empty($optAtr))
                {
                    //close the option tag
                    $select.='>';
                }
                //if the option attribute is not empty
                else
                {
                    foreach($optAtr as $optattr=>$optval)
                    {
                        //append the option attribute to the option tag[<option name="name">]
                        $select.=$optattr.'='.$optval;
                    }
                    //close the option tag
                    $select.='>';

                }
                //attach the values to the option tag<option>...
                $select.= $val;
                //close the option tag
                $select.='</option>';
            }
            //close the select tag
            $select.='</select>';
        }
        else
        {
            echo "the option value cannot be empty";
        }
        echo $select;

    }
}







