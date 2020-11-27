<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\DependentPhpDocs;

interface Foo extends \IteratorAggregate
{
    /** @param Foo[]|Foo|\Iterator $pages */
    public function addPages($pages);
    /** non-empty */
    public function getIterator();
}
