<?php

namespace _PhpScoper88fe6e0ad041\TestFunctionTypehints;

class FooFunctionTypehints
{
}
trait SomeTrait
{
}
function foo(\_PhpScoper88fe6e0ad041\TestFunctionTypehints\FooFunctionTypehints $foo, $bar, array $lorem) : \_PhpScoper88fe6e0ad041\TestFunctionTypehints\NonexistentClass
{
}
function bar(\_PhpScoper88fe6e0ad041\TestFunctionTypehints\BarFunctionTypehints $bar) : array
{
}
function baz(...$bar) : \_PhpScoper88fe6e0ad041\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParent()
{
}
function badCaseTypehints(\_PhpScoper88fe6e0ad041\TestFunctionTypehints\fOOFunctionTypehints $foo) : \_PhpScoper88fe6e0ad041\TestFunctionTypehints\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDoc(\_PhpScoper88fe6e0ad041\TestFunctionTypehints\FooFunctionTypehints $foo) : \_PhpScoper88fe6e0ad041\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDoc(\_PhpScoper88fe6e0ad041\TestFunctionTypehints\FOOFunctionTypehints $foo) : \_PhpScoper88fe6e0ad041\TestFunctionTypehints\FOOFunctionTypehints
{
}
function referencesTraitsInNative(\_PhpScoper88fe6e0ad041\TestFunctionTypehints\SomeTrait $trait) : \_PhpScoper88fe6e0ad041\TestFunctionTypehints\SomeTrait
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
