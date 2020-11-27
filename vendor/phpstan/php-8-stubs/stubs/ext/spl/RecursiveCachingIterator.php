<?php

namespace _PhpScoper006a73f0e455;

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
\class_alias('_PhpScoper006a73f0e455\\RecursiveCachingIterator', 'RecursiveCachingIterator', \false);
