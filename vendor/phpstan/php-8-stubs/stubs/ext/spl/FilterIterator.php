<?php

namespace _PhpScoper26e51eeacccf;

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
\class_alias('_PhpScoper26e51eeacccf\\FilterIterator', 'FilterIterator', \false);
