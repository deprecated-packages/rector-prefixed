<?php

namespace _PhpScopera143bcca66cb;

class RecursiveCallbackFilterIterator extends \CallbackFilterIterator implements \RecursiveIterator
{
    public function __construct(\RecursiveIterator $iterator, callable $callback)
    {
    }
    /**
     * @return bool
     * @implementation-alias RecursiveFilterIterator::hasChildren
     */
    public function hasChildren()
    {
    }
    /** @return RecursiveCallbackFilterIterator */
    public function getChildren()
    {
    }
}
\class_alias('_PhpScopera143bcca66cb\\RecursiveCallbackFilterIterator', 'RecursiveCallbackFilterIterator', \false);
