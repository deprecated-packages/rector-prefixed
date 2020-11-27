<?php

namespace _PhpScoperbd5d0c5f7638;

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
\class_alias('_PhpScoperbd5d0c5f7638\\RecursiveCallbackFilterIterator', 'RecursiveCallbackFilterIterator', \false);
