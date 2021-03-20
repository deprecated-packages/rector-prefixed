<?php

declare (strict_types=1);
namespace RectorPrefix20210320\Nette\ComponentModel;

if (\class_exists('RectorPrefix20210320\\Nette\\ComponentModel\\Component')) {
    return;
}
class Component extends \RectorPrefix20210320\Nette\ComponentModel\Container implements \ArrayAccess
{
    public function offsetExists($offset)
    {
    }
    public function offsetGet($offset)
    {
    }
    public function offsetSet($offset, $value)
    {
    }
    public function offsetUnset($offset)
    {
    }
}
