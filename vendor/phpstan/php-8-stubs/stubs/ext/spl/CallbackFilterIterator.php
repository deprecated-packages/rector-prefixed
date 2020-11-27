<?php

namespace _PhpScoper88fe6e0ad041;

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
\class_alias('_PhpScoper88fe6e0ad041\\CallbackFilterIterator', 'CallbackFilterIterator', \false);
