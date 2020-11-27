<?php

namespace _PhpScoperbd5d0c5f7638;

interface SeekableIterator extends \Iterator
{
    /** @return void */
    public function seek(int $offset);
}
\class_alias('_PhpScoperbd5d0c5f7638\\SeekableIterator', 'SeekableIterator', \false);
