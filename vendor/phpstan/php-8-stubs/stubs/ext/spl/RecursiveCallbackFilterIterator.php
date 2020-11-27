<?php

namespace _PhpScoper26e51eeacccf;

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
\class_alias('_PhpScoper26e51eeacccf\\RecursiveCallbackFilterIterator', 'RecursiveCallbackFilterIterator', \false);
