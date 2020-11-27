<?php

namespace _PhpScoperbd5d0c5f7638;

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
\class_alias('_PhpScoperbd5d0c5f7638\\FilterIterator', 'FilterIterator', \false);
