<?php

namespace _PhpScoperabd03f0baf05;

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
\class_alias('_PhpScoperabd03f0baf05\\CallbackFilterIterator', 'CallbackFilterIterator', \false);
