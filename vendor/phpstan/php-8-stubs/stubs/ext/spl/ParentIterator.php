<?php

namespace _PhpScoperbd5d0c5f7638;

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
\class_alias('_PhpScoperbd5d0c5f7638\\ParentIterator', 'ParentIterator', \false);
