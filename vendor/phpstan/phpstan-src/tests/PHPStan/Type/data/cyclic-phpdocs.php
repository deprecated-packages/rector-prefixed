<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\CyclicPhpDocs;

interface Foo extends \IteratorAggregate
{
    /** @return iterable<Foo> | Foo */
    public function getIterator();
}
