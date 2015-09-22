<?php
/**
 * Created by JetBrains PhpStorm.
 * User: makinwab
 * Date: 9/4/13
 * Time: 11:15 AM
 * To change this template use File | Settings | File Templates.
 */

abstract class daocollection implements Iterator
{
    protected $position = 0;
    protected $storage = [];

    abstract function getwithdata();
    /*abstract function getpaginateddata($position);*/

    protected function populate($array, $dataobject)
    {
        foreach($array as $item)
        {
            $object = new $dataobject();

            foreach($item as $key => $val)
            {
                $object->$key = $val;
            }

            $this->storage[] = $object;
        }
    }

    public function saveall()
    {
        foreach ($this as $item) {
            $item->save();
        }
    }

    public function current()
    {
        return $this->storage[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position++;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return isset($this->storage[$this->position]);
    }

}
