<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\CyclicPhpDocs;

interface Foo extends \IteratorAggregate
{
    /** @return iterable<Foo> | Foo */
    public function getIterator();
}
