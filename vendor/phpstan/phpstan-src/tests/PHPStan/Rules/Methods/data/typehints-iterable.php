<?php

namespace _PhpScoper006a73f0e455\TestMethodTypehints;

class IterableTypehints
{
    /**
     * @param iterable<NonexistentClass, AnotherNonexistentClass> $iterable
     */
    public function doFoo(iterable $iterable)
    {
    }
}
