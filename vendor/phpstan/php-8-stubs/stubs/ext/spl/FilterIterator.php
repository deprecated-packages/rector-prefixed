<?php

namespace _PhpScoper006a73f0e455;

abstract class FilterIterator extends \IteratorIterator
{
    /** @return bool */
    public abstract function accept();
    public function __construct(\Iterator $iterator)
    {
    }
    /** @return void */
    public function rewind()
    {
    }
    /** @return void */
    public function next()
    {
    }
}
\class_alias('_PhpScoper006a73f0e455\\FilterIterator', 'FilterIterator', \false);
