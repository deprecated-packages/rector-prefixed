<?php

namespace _PhpScoper006a73f0e455;

interface SeekableIterator extends \Iterator
{
    /** @return void */
    public function seek(int $offset);
}
\class_alias('_PhpScoper006a73f0e455\\SeekableIterator', 'SeekableIterator', \false);
