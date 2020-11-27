<?php

namespace _PhpScopera143bcca66cb;

class CallbackFilterIterator extends \FilterIterator
{
    public function __construct(\Iterator $iterator, callable $callback)
    {
    }
    /** @return bool */
    public function accept()
    {
    }
}
\class_alias('_PhpScopera143bcca66cb\\CallbackFilterIterator', 'CallbackFilterIterator', \false);
