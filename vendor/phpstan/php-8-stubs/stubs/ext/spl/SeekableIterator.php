<?php

namespace _PhpScoper88fe6e0ad041;

interface SeekableIterator extends \Iterator
{
    /** @return void */
    public function seek(int $offset);
}
\class_alias('_PhpScoper88fe6e0ad041\\SeekableIterator', 'SeekableIterator', \false);
