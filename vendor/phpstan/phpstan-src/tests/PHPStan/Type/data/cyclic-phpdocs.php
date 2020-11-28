<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\CyclicPhpDocs;

interface Foo extends \IteratorAggregate
{
    /** @return iterable<Foo> | Foo */
    public function getIterator();
}
