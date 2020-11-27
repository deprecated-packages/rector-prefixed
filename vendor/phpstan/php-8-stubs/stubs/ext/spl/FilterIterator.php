<?php

namespace _PhpScoper88fe6e0ad041;

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
\class_alias('_PhpScoper88fe6e0ad041\\FilterIterator', 'FilterIterator', \false);
