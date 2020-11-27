<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\DependentPhpDocs;

interface Foo extends \IteratorAggregate
{
    /** @param Foo[]|Foo|\Iterator $pages */
    public function addPages($pages);
    /** non-empty */
    public function getIterator();
}
