<?php

namespace PHPStan\Generics\VaryingAcceptor;

class A
{
}
class B extends \PHPStan\Generics\VaryingAcceptor\A
{
}
/**
 * @template T
 *
 * @param callable(T):void $t1
 * @param T $t2
 */
function apply(callable $t1, $t2) : void
{
    $t1($t2);
}
/**
 * @template T
 *
 * @param T $t2
 * @param callable(T):void $t1
 */
function applyReversed($t2, callable $t1) : void
{
    $t1($t2);
}
function testApply()
{
    apply(function (\PHPStan\Generics\VaryingAcceptor\A $_i) : void {
    }, new \PHPStan\Generics\VaryingAcceptor\A());
    apply(function (\PHPStan\Generics\VaryingAcceptor\B $_i) : void {
    }, new \PHPStan\Generics\VaryingAcceptor\B());
    apply(function (\PHPStan\Generics\VaryingAcceptor\A $_i) : void {
    }, new \PHPStan\Generics\VaryingAcceptor\B());
    apply(function (\PHPStan\Generics\VaryingAcceptor\B $_i) : void {
    }, new \PHPStan\Generics\VaryingAcceptor\A());
    applyReversed(new \PHPStan\Generics\VaryingAcceptor\A(), function (\PHPStan\Generics\VaryingAcceptor\A $_i) : void {
    });
    applyReversed(new \PHPStan\Generics\VaryingAcceptor\B(), function (\PHPStan\Generics\VaryingAcceptor\B $_i) : void {
    });
    applyReversed(new \PHPStan\Generics\VaryingAcceptor\B(), function (\PHPStan\Generics\VaryingAcceptor\A $_i) : void {
    });
    applyReversed(new \PHPStan\Generics\VaryingAcceptor\A(), function (\PHPStan\Generics\VaryingAcceptor\B $_i) : void {
    });
}
/**
 * @template T
 *
 * @param callable(callable():T):T $closure
 * @return T
 */
function bar(callable $closure)
{
    throw new \Exception();
}
/** @param callable(callable():int):string $callable */
function testBar($callable) : void
{
    bar($callable);
}
