<?php

namespace _PhpScoper88fe6e0ad041;

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
\class_alias('_PhpScoper88fe6e0ad041\\InternalIterator', 'InternalIterator', \false);
