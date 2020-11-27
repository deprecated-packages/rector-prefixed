<?php

namespace _PhpScoperbd5d0c5f7638;

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
\class_alias('_PhpScoperbd5d0c5f7638\\CallbackFilterIterator', 'CallbackFilterIterator', \false);
