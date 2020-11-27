<?php

namespace _PhpScoperbd5d0c5f7638\TestFunctionTypehints;

class FooFunctionTypehints
{
}
trait SomeTrait
{
}
function foo(\_PhpScoperbd5d0c5f7638\TestFunctionTypehints\FooFunctionTypehints $foo, $bar, array $lorem) : \_PhpScoperbd5d0c5f7638\TestFunctionTypehints\NonexistentClass
{
}
function bar(\_PhpScoperbd5d0c5f7638\TestFunctionTypehints\BarFunctionTypehints $bar) : array
{
}
function baz(...$bar) : \_PhpScoperbd5d0c5f7638\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParent()
{
}
function badCaseTypehints(\_PhpScoperbd5d0c5f7638\TestFunctionTypehints\fOOFunctionTypehints $foo) : \_PhpScoperbd5d0c5f7638\TestFunctionTypehints\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDoc(\_PhpScoperbd5d0c5f7638\TestFunctionTypehints\FooFunctionTypehints $foo) : \_PhpScoperbd5d0c5f7638\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDoc(\_PhpScoperbd5d0c5f7638\TestFunctionTypehints\FOOFunctionTypehints $foo) : \_PhpScoperbd5d0c5f7638\TestFunctionTypehints\FOOFunctionTypehints
{
}
function referencesTraitsInNative(\_PhpScoperbd5d0c5f7638\TestFunctionTypehints\SomeTrait $trait) : \_PhpScoperbd5d0c5f7638\TestFunctionTypehints\SomeTrait
{
}
/**
 * @param SomeTrait $trait
 * @return SomeTrait
 */
function referencesTraitsInPhpDoc($trait)
{
}
/**
 * @param class-string<SomeNonexistentClass> $string
 */
function genericClassString(string $string)
{
}
/**
 * @template T of SomeNonexistentClass
 * @param class-string<T> $string
 */
function genericTemplateClassString(string $string)
{
}
