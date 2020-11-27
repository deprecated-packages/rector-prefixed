<?php

namespace _PhpScopera143bcca66cb;

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
\class_alias('_PhpScopera143bcca66cb\\RecursiveCachingIterator', 'RecursiveCachingIterator', \false);
