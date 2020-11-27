<?php

namespace _PhpScoperbd5d0c5f7638;

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
\class_alias('_PhpScoperbd5d0c5f7638\\GlobIterator', 'GlobIterator', \false);
