<?php

namespace _PhpScoper88fe6e0ad041\Generics\Bug2574;

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
function foo(\_PhpScoper88fe6e0ad041\Generics\Bug2574\Model $m) : \_PhpScoper88fe6e0ad041\Generics\Bug2574\Model
{
    return $m->newInstance();
}
