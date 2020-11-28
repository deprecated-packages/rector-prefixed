<?php

namespace _PhpScoperabd03f0baf05\Generics\Bug2574;

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
function foo(\_PhpScoperabd03f0baf05\Generics\Bug2574\Model $m) : \_PhpScoperabd03f0baf05\Generics\Bug2574\Model
{
    return $m->newInstance();
}
