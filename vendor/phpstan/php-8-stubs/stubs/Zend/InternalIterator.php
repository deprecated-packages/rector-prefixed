<?php

namespace _PhpScopera143bcca66cb;

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
\class_alias('_PhpScopera143bcca66cb\\InternalIterator', 'InternalIterator', \false);
