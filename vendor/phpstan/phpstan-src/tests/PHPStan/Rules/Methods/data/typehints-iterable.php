<?php

namespace _PhpScoper26e51eeacccf\TestMethodTypehints;

class IterableTypehints
{
    /**
     * @param iterable<NonexistentClass, AnotherNonexistentClass> $iterable
     */
    public function doFoo(iterable $iterable)
    {
    }
}
