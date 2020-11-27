<?php

namespace _PhpScoper88fe6e0ad041;

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
\class_alias('_PhpScoper88fe6e0ad041\\RecursiveCachingIterator', 'RecursiveCachingIterator', \false);
