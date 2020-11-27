<?php

namespace _PhpScoper88fe6e0ad041;

#ifdef HAVE_GLOB
class GlobIterator extends \FilesystemIterator implements \Countable
{
    public function __construct(string $pattern, int $flags = \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO)
    {
    }
    /** @return int */
    public function count()
    {
    }
}
#ifdef HAVE_GLOB
\class_alias('_PhpScoper88fe6e0ad041\\GlobIterator', 'GlobIterator', \false);
