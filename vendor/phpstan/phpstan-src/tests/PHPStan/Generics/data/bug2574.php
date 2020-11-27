<?php

namespace _PhpScopera143bcca66cb\Generics\Bug2574;

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
function foo(\_PhpScopera143bcca66cb\Generics\Bug2574\Model $m) : \_PhpScopera143bcca66cb\Generics\Bug2574\Model
{
    return $m->newInstance();
}
