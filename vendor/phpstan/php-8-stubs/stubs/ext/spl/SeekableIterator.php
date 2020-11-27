<?php

namespace _PhpScoper26e51eeacccf;

interface SeekableIterator extends \Iterator
{
    /** @return void */
    public function seek(int $offset);
}
\class_alias('_PhpScoper26e51eeacccf\\SeekableIterator', 'SeekableIterator', \false);
