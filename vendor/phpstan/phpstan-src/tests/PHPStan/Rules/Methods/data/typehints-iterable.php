<?php

namespace _PhpScoperabd03f0baf05\TestMethodTypehints;

class IterableTypehints
{
    /**
     * @param iterable<NonexistentClass, AnotherNonexistentClass> $iterable
     */
    public function doFoo(iterable $iterable)
    {
    }
}
