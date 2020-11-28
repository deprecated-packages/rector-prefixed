<?php

namespace _PhpScoperabd03f0baf05;

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
\class_alias('_PhpScoperabd03f0baf05\\FilterIterator', 'FilterIterator', \false);
