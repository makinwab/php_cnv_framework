<?php
/**
 * Created by JetBrains PhpStorm.
 * User: pguto
 * Date: 08/08/13
 * Time: 19:40
 * To change this template use File | Settings | File Templates.
 */
require_once('kbTobyte.php');
require_once('mbTobyte.php');

class CN_upload {
    protected $max;
    protected $unit;
    protected $extension=[];
    protected $files=[];
    protected $accepted=[];
    protected $newMax;
    protected $messages=[];
    protected $passed=[];
    protected $typeStatus=[];
    /* constructor
  *
   * creates a formatted input check box tag [ <input type =>"check"]; {public}
   *
   * Params description:
   * $max   - this is the maximum size you want your application to upload
   *$extension -this is an array of the allowed file type
   * $unit  - this is the unit of the maximum file size .either mb or kb
   * *******HOW TO USE******
   *   create an array of allowed mime and pass it into the CN_upload Class
     * $max=10;
     * $unit='kb';
     * $extension=['image/jpg','image/jpeg'];
     * new CN_upload($max,$unit,$extension);
  */

    public function __construct($max,$unitFrom='',$unitTo='',$extension=[])
    {

        $this->max=$max;
       /* $this->unit=$unit;*/

        $this->extension=$extension;
        $this->accepted;
        $con=$unitFrom;
        $con.='To';
        $con.=$unitTo;
       $this->newMax=$this->$con();
        /*echo $this->newMax;*/


      /*  if(is_int($max))
        {
            if($unit=='mb')
            {
                $me=new CN_SizeConverter($this->max,$this->unit);
                $this->newMax=$me->convertFromMb();
            }
            elseif($unit=='kb')
            {
                $me=new CN_SizeConverter($this->max,$this->unit);
                $this->newMax=$me->convertFromKb();
            }*/
            /*  $this->newMax=$me;*/
       /* }
        else
        {
            throw new Exception("integer value expected for maximum size");
        }*/

        /* define('UPLOAD_DIR','$this->directory=$directory');*/
    }

    /* multiple
  *
   * this function performs most of the operation in this factory
   *
   * Params description:
   * $files=[] - this is an array because a user of this factory may decide to upload more than one file
   *
   * *******HOW TO USE******
   *   1...create  array of the file or files that you want to upload
   * pass it into the multiples function
     * $file=['me','mee'];
     * multiple($file);
     *
     *
     *
     * >>>>>>WHAT IS HAPPENING UNDERNEATH>>>>>>
     * when the array of the file is being passed as an argument,
     * the first operation being performed by the function is to check if it is an array.
     * If the passed file is not an array it throws an exception
     * else
     * it tends to perform some operation on each file in the array
     *
     *
     * 1>>>it checks if the submitted file has any file within it
     * if there is any empty file, it empty the accepted array if there is a value in it and throws an error message
     * else if there is no empty ile it moves to>>
     *
     * >>2>>>it checks if it is not greater than the stipulated size , if it is it throws an error message and
     * empty the accepted array if a value has been passed to it else it moves to >>
     *
     * >>3>>>it checks if its mime is among the allowed types ,if it is not it throws an error message  and empty the accepted
     * array else if it is it and all the three conditions has been met it the accepted files are being passed ito the accepted array
     *
     *
     *
  */
    public function multiple($files=[])
    {


        if(!is_array($files))
        {
            throw new Exception('file must be an array');
        }
        else
        {

                foreach($files as $f=>$file)
                {
                    $CN_sizeGood=$this->CN_checkSize($_FILES[$file]['size']);
                    $ext_type = strrchr($_FILES[$file]['name'], '.');

                    $CN_typeGood=$this->CN_checkExt($ext_type);

                    $CN_empty=$this->CN_isEmpty($_FILES[$file]['name']);

                    if($CN_empty)
                    {
                        echo ' file '.$file.' submitted with no file specified<br>';
                        $this->accepted=[];
                        break;

                    }
                    else
                    {

                        if($CN_sizeGood )
                        {
                            if($CN_typeGood)
                            {

                                $this->accepted[]=$file;
                                /* echo 'file '.$_FILES[$file]['name'].' with type ' .$_FILES[$file]['type'] .' is a valid accepted type<br>';
                                 echo 'file '.$file.' with size ' .$_FILES[$file]['size'] .' is not greater than '.$this->newMax.'<br>';*/
                            }
                            else
                            {
                                /*$this->messages[]=*/
                                echo 'type '.$_FILES[$file]['type'].'  for file '.$_FILES[$file]['name'].' not supported';
                                $this->accepted=[];
                                break;
                                /* echo 'file '.$file.' with type ' .$_FILES[$file]['type'] .' is not a valid accepted type<br>';*/
                            }


                        }
                        else
                        {
                            /*$this->messages[]=*/echo 'size of file '.$_FILES[$file]['name'].' is greater than the max size';
                            $this->accepted=[];
                            break;
                            /*echo 'file '.$file.' with size ' .$_FILES[$file]['size'] .'is greater than '.$this->newMax.'<br>';*/
                        }
                    }

                }



        }



    }
    /* CN_upload
      *
       * creates a formatted input check box tag [ <input type =>"check"]; {public}
       *
       * Params description:
       * $destination - where the uploaded files would be stored
       *
     * $newName=a user might decide to rename a file after it has been uploaded
       * *******HOW TO USE******
       *   optional>>>>>create an array of the new name for each file that you want to upload
     * $newName=['udoka','bukky','maja']
     * note:- ensure the lenght of the file array and the new name array are the same
     *
     * create a string of the destination
     * $dest='..\uploadClass\me';
     * then pass this param to the function
     *
     * CN_upload($dest,$newName)
     *
     *
     *
     * >>>>>>WHAT IS HAPPENING UNDERNEATH
      */
    public function CN_upload($destination,$newName=[])
    {
        if(!realpath($destination))
        {
            echo $destination.' does not exist please check ur file path';
        }
        else
        {

            if(empty($this->accepted))
            {


            }
            else
            {
                if(empty($newName))
                {

                    foreach($this->accepted as $file)
                    {

                        /* echo '<br>file '.$file.'<br>';*/
                        if($_FILES[$file]['error']==0)
                        {
                            $send=move_uploaded_file($_FILES[$file]['tmp_name'],$destination.'/'.$_FILES[$file]['name']);

                            if($send)
                            {

                            }
                            else
                            {
                                echo 'unable to upload because '.$_FILES[$file]['error'];
                            }
                        }
                        elseif($_FILES[$file]['error']==1)
                        {
                            echo 'file exeed max default size';
                        }




                    }
                    echo 'succesful';

                }
                else
                {

                    if(count($this->accepted)!=count($newName))
                    {

                    }
                    else
                    {
                        foreach($this->accepted as $file)
                        {

                            foreach($newName as $n=>$name)
                            {
                                if($_FILES[$file]['error']==0)
                                {
                                    $extn=strrchr($_FILES[$this->accepted[$n]]['name'],'.');
                                    $send=move_uploaded_file($_FILES[$this->accepted[$n]]['tmp_name'],$destination.'/'.$newName[$n].$extn);

                                    if($send)
                                    {
                                        echo 'succesful';
                                    }
                                    else
                                    {
                                        var_dump($_FILES[$file]['error']);
                                    }
                                }
                                elseif($_FILES[$file]['error']==1)
                                {
                                    echo 'file exeed max default size';
                                }
                            }
                            break;
                        }
                    }

                }

            }
        }
    }



    protected function CN_isEmpty($file)
    {
        $this->typeStatus=false;
        if(empty($file))
        {
            $this->typeStatus=true;
        }
        return $this->typeStatus;
    }

    protected  function CN_checkSize($file)
    {
        $this->typeStatus=false;
        if($file < $this->newMax)
        {
            $this->typeStatus=true;
        }
        return $this->typeStatus;
    }

    protected function CN_checkExt($file)
    {
        $this->typeStatus=false;
        foreach($this->extension as $ext)
        {

            if($ext==$file)
            {

                $this->typeStatus=true;
                break;
            }


        }

        return $this->typeStatus;
    }

    protected function kbTobyte()
    {
        $sizeInKb=($this->max*1024);
        return $sizeInKb;
    }

    protected function mbTobyte()
    {
        $sizeInMb=(($this->max*1024)*1000);
        return $sizeInMb;
    }


}
