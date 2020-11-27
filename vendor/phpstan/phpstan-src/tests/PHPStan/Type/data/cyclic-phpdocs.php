<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\CyclicPhpDocs;

interface Foo extends \IteratorAggregate
{
    /** @return iterable<Foo> | Foo */
    public function getIterator();
}
