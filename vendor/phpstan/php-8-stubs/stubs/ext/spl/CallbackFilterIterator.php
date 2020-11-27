<?php

namespace _PhpScoper26e51eeacccf;

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
\class_alias('_PhpScoper26e51eeacccf\\CallbackFilterIterator', 'CallbackFilterIterator', \false);
