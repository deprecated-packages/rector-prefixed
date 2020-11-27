<?php

namespace _PhpScoper006a73f0e455;

class FilesystemIterator extends \DirectoryIterator
{
    public function __construct(string $directory, int $flags = \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS)
    {
    }
    /** @return void */
    public function rewind()
    {
    }
    /** @return string */
    public function key()
    {
    }
    /** @return string|SplFileInfo|self */
    public function current()
    {
    }
    /** @return int */
    public function getFlags()
    {
    }
    /** @return void */
    public function setFlags(int $flags)
    {
    }
}
\class_alias('_PhpScoper006a73f0e455\\FilesystemIterator', 'FilesystemIterator', \false);
