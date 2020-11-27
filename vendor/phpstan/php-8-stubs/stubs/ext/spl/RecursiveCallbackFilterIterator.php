<?php

namespace _PhpScoper88fe6e0ad041;

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
\class_alias('_PhpScoper88fe6e0ad041\\RecursiveCallbackFilterIterator', 'RecursiveCallbackFilterIterator', \false);
