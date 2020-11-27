<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\CyclicPhpDocs;

interface Foo extends \IteratorAggregate
{
    /** @return iterable<Foo> | Foo */
    public function getIterator();
}
