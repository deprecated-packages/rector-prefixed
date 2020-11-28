<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\DependentPhpDocs;

interface Foo extends \IteratorAggregate
{
    /** @param Foo[]|Foo|\Iterator $pages */
    public function addPages($pages);
    /** non-empty */
    public function getIterator();
}
