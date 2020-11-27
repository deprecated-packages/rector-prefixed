<?php

namespace _PhpScoperbd5d0c5f7638\TestMethodTypehints;

class IterableTypehints
{
    /**
     * @param iterable<NonexistentClass, AnotherNonexistentClass> $iterable
     */
    public function doFoo(iterable $iterable)
    {
    }
}
