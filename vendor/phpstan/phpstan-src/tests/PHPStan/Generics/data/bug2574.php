<?php

namespace _PhpScoper006a73f0e455\Generics\Bug2574;

abstract class Model
{
    /** @return static */
    public function newInstance()
    {
        return new static();
    }
}
/**
 * @template T of Model
 * @param T $m
 * @return T
 */
function foo(\_PhpScoper006a73f0e455\Generics\Bug2574\Model $m) : \_PhpScoper006a73f0e455\Generics\Bug2574\Model
{
    return $m->newInstance();
}
