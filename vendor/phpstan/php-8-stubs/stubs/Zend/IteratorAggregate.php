<?php

namespace _PhpScopera143bcca66cb;

interface IteratorAggregate extends \Traversable
{
    /** @return Traversable */
    public function getIterator();
}
\class_alias('_PhpScopera143bcca66cb\\IteratorAggregate', 'IteratorAggregate', \false);
