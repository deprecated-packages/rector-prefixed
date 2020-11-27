<?php

namespace _PhpScoper006a73f0e455;

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
\class_alias('_PhpScoper006a73f0e455\\RecursiveCallbackFilterIterator', 'RecursiveCallbackFilterIterator', \false);
