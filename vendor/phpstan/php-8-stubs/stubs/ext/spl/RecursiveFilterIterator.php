<?php

namespace _PhpScoper006a73f0e455;

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
\class_alias('_PhpScoper006a73f0e455\\RecursiveFilterIterator', 'RecursiveFilterIterator', \false);
