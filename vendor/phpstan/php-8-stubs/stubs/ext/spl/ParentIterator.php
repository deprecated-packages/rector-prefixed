<?php

namespace _PhpScoper88fe6e0ad041;

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
\class_alias('_PhpScoper88fe6e0ad041\\ParentIterator', 'ParentIterator', \false);
