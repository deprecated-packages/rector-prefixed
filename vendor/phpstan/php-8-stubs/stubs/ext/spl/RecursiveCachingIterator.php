<?php

namespace _PhpScoperabd03f0baf05;

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
\class_alias('_PhpScoperabd03f0baf05\\RecursiveCachingIterator', 'RecursiveCachingIterator', \false);
