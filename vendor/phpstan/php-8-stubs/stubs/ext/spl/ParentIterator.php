<?php

namespace _PhpScoperabd03f0baf05;

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
\class_alias('_PhpScoperabd03f0baf05\\ParentIterator', 'ParentIterator', \false);
