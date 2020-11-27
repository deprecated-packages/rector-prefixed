<?php

namespace _PhpScoperbd5d0c5f7638\Generics\Bug2574;

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
function foo(\_PhpScoperbd5d0c5f7638\Generics\Bug2574\Model $m) : \_PhpScoperbd5d0c5f7638\Generics\Bug2574\Model
{
    return $m->newInstance();
}
