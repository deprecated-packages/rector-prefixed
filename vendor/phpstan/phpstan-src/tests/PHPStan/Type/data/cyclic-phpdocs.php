<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\CyclicPhpDocs;

interface Foo extends \IteratorAggregate
{
    /** @return iterable<Foo> | Foo */
    public function getIterator();
}
