<?php

namespace _PhpScoper88fe6e0ad041\FunctionSignatureVariance;

/** @template-covariant T */
interface Out
{
}
/** @template T */
interface Invariant
{
}
/**
 * @template-covariant T
 * @param Out<T> $a
 * @param Invariant<T> $b
 * @param T $c
 * @return T
 */
function f($a, $b, $c)
{
    return $c;
}
