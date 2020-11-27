<?php

namespace _PhpScoper26e51eeacccf;

final class InternalIterator implements \Iterator
{
    private function __construct();
    /** @return mixed */
    public function current();
    /** @return mixed */
    public function key();
    public function next() : void;
    public function valid() : bool;
    public function rewind() : void;
}
\class_alias('_PhpScoper26e51eeacccf\\InternalIterator', 'InternalIterator', \false);
