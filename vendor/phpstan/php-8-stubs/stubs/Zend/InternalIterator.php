<?php

namespace _PhpScoperbd5d0c5f7638;

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
\class_alias('_PhpScoperbd5d0c5f7638\\InternalIterator', 'InternalIterator', \false);
