<?php

namespace _PhpScopera143bcca66cb;

interface SeekableIterator extends \Iterator
{
    /** @return void */
    public function seek(int $offset);
}
\class_alias('_PhpScopera143bcca66cb\\SeekableIterator', 'SeekableIterator', \false);
