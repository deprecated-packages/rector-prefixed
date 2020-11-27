<?php

namespace _PhpScoper006a73f0e455\FunctionSignatureVariance;

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
