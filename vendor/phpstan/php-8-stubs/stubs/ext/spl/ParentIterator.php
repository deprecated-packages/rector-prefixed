<?php

namespace _PhpScopera143bcca66cb;

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
\class_alias('_PhpScopera143bcca66cb\\ParentIterator', 'ParentIterator', \false);
