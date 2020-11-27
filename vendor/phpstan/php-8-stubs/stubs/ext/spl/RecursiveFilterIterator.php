<?php

namespace _PhpScoper88fe6e0ad041;

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
\class_alias('_PhpScoper88fe6e0ad041\\RecursiveFilterIterator', 'RecursiveFilterIterator', \false);
