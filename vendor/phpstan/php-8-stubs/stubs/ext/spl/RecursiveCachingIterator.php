<?php

namespace _PhpScoperbd5d0c5f7638;

class RecursiveCachingIterator extends \CachingIterator implements \RecursiveIterator
{
    public function __construct(\Iterator $iterator, int $flags = self::CALL_TOSTRING)
    {
    }
    /** @return bool */
    public function hasChildren()
    {
    }
    /** @return RecursiveCachingIterator|null */
    public function getChildren()
    {
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\RecursiveCachingIterator', 'RecursiveCachingIterator', \false);
