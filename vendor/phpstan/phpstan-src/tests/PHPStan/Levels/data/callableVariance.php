<?php

namespace _PhpScopera143bcca66cb\Levels\CallableVariance;

class A
{
}
class B extends \_PhpScopera143bcca66cb\Levels\CallableVariance\A
{
}
class C extends \_PhpScopera143bcca66cb\Levels\CallableVariance\B
{
}
/**
 * @param callable(B): void $cb
 */
function a(callable $cb) : void
{
    $cb(new \_PhpScopera143bcca66cb\Levels\CallableVariance\A());
    $cb(new \_PhpScopera143bcca66cb\Levels\CallableVariance\B());
    $cb(new \_PhpScopera143bcca66cb\Levels\CallableVariance\C());
}
/**
 * @param callable(B): void $cb
 */
function b(callable $cb) : void
{
}
/**
 * @param callable(A): void $a
 * @param callable(B): void $b
 * @param callable(C): void $c
 */
function testB($a, $b, $c) : void
{
    b(function (\_PhpScopera143bcca66cb\Levels\CallableVariance\A $a) : void {
    });
    b(function (\_PhpScopera143bcca66cb\Levels\CallableVariance\B $b) : void {
    });
    b(function (\_PhpScopera143bcca66cb\Levels\CallableVariance\C $c) : void {
    });
    b($a);
    b($b);
    b($c);
}
/**
 * @param callable(): B $cb
 */
function c(callable $cb) : void
{
}
/**
 * @param callable(): A $a
 * @param callable(): B $b
 * @param callable(): C $c
 */
function testC($a, $b, $c) : void
{
    c(function () : A {
        throw new \Exception();
    });
    c(function () : B {
        throw new \Exception();
    });
    c(function () : C {
        throw new \Exception();
    });
    c($a);
    c($b);
    c($c);
}
/**
 * @param callable(callable(): B): B $cb
 */
function d(callable $cb)
{
}
/**
 * @param callable(callable(): C): C $a
 * @param callable(callable(): B): B $b
 * @param callable(callable(): A): C $c
 * @param callable(callable(): A): A $d
 * @param callable(callable(): C): A $e
 */
function testD($a, $b, $c, $d, $e)
{
    d($a);
    d($b);
    d($c);
    d($d);
    d($e);
}
