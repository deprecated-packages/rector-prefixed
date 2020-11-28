<?php

namespace _PhpScoperabd03f0baf05;

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
\class_alias('_PhpScoperabd03f0baf05\\RecursiveFilterIterator', 'RecursiveFilterIterator', \false);
