<?php

namespace _PhpScopera143bcca66cb\TestFunctionTypehints;

class FooFunctionTypehints
{
}
trait SomeTrait
{
}
function foo(\_PhpScopera143bcca66cb\TestFunctionTypehints\FooFunctionTypehints $foo, $bar, array $lorem) : \_PhpScopera143bcca66cb\TestFunctionTypehints\NonexistentClass
{
}
function bar(\_PhpScopera143bcca66cb\TestFunctionTypehints\BarFunctionTypehints $bar) : array
{
}
function baz(...$bar) : \_PhpScopera143bcca66cb\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParent()
{
}
function badCaseTypehints(\_PhpScopera143bcca66cb\TestFunctionTypehints\fOOFunctionTypehints $foo) : \_PhpScopera143bcca66cb\TestFunctionTypehints\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDoc(\_PhpScopera143bcca66cb\TestFunctionTypehints\FooFunctionTypehints $foo) : \_PhpScopera143bcca66cb\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDoc(\_PhpScopera143bcca66cb\TestFunctionTypehints\FOOFunctionTypehints $foo) : \_PhpScopera143bcca66cb\TestFunctionTypehints\FOOFunctionTypehints
{
}
function referencesTraitsInNative(\_PhpScopera143bcca66cb\TestFunctionTypehints\SomeTrait $trait) : \_PhpScopera143bcca66cb\TestFunctionTypehints\SomeTrait
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
