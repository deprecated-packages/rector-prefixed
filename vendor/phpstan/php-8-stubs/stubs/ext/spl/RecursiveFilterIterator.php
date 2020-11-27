<?php

namespace _PhpScoper26e51eeacccf;

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
\class_alias('_PhpScoper26e51eeacccf\\RecursiveFilterIterator', 'RecursiveFilterIterator', \false);
