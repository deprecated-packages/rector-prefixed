<?php

namespace _PhpScoper26e51eeacccf;

class ParentIterator extends \RecursiveFilterIterator
{
    public function __construct(\RecursiveIterator $iterator)
    {
    }
    /**
     * @return bool
     * @implementation-alias RecursiveFilterIterator::hasChildren
     */
    public function accept()
    {
    }
}
\class_alias('_PhpScoper26e51eeacccf\\ParentIterator', 'ParentIterator', \false);
