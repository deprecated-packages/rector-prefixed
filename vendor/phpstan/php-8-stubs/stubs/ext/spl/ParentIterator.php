<?php

namespace _PhpScoper006a73f0e455;

class ParentIterator extends \RecursiveFilterIterator
{
    public function __construct(\RecursiveIterator $iterator)
    {
    }
    /**
     * @return bool
     * @implementation-alias RecursiveFilterIterator::hasChildren
     */
    public function accept()
    {
    }
}
\class_alias('_PhpScoper006a73f0e455\\ParentIterator', 'ParentIterator', \false);
