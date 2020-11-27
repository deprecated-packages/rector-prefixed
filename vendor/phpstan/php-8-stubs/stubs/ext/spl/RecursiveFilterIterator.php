<?php

namespace _PhpScoperbd5d0c5f7638;

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
\class_alias('_PhpScoperbd5d0c5f7638\\RecursiveFilterIterator', 'RecursiveFilterIterator', \false);
