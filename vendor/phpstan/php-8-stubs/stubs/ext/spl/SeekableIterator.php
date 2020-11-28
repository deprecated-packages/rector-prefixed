<?php

namespace _PhpScoperabd03f0baf05;

interface SeekableIterator extends \Iterator
{
    /** @return void */
    public function seek(int $offset);
}
\class_alias('_PhpScoperabd03f0baf05\\SeekableIterator', 'SeekableIterator', \false);
