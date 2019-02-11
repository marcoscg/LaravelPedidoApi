<?php

namespace App\Entities;

abstract class AbstractEntity
{

    protected function set($property, $value)
    {
        $methodName = "set".ucfirst($property);

        if (method_exists($this, $methodName)) {
            call_user_func_array(array($this,$methodName), array($value));
        }
    }

    protected function get($method)
    {
        $property = lcfirst(substr($method, 3));
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), array());
        }
    }

    public function setAll(Array $data)
    {
        foreach($data as $k=>$v)
            $this->set($k, $v);
        return $this;
    }

    public function toArray()
    {
        $array = [];

        foreach ($this as $k => &$v)
            $array[$k] = $v;

        return $array;
    }
}