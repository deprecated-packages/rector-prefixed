<?php

namespace _PhpScoper006a73f0e455;

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
\class_alias('_PhpScoper006a73f0e455\\CallbackFilterIterator', 'CallbackFilterIterator', \false);
