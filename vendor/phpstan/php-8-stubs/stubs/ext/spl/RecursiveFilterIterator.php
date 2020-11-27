<?php

namespace _PhpScopera143bcca66cb;

abstract class RecursiveFilterIterator extends \FilterIterator implements \RecursiveIterator
{
    public function __construct(\RecursiveIterator $iterator)
    {
    }
    /** @return bool */
    public function hasChildren()
    {
    }
    /** @return RecursiveFilterIterator|null */
    public function getChildren()
    {
    }
}
\class_alias('_PhpScopera143bcca66cb\\RecursiveFilterIterator', 'RecursiveFilterIterator', \false);
