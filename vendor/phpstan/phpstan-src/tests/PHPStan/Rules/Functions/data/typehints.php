<?php

namespace _PhpScoperabd03f0baf05\TestFunctionTypehints;

class FooFunctionTypehints
{
}
trait SomeTrait
{
}
function foo(\_PhpScoperabd03f0baf05\TestFunctionTypehints\FooFunctionTypehints $foo, $bar, array $lorem) : \_PhpScoperabd03f0baf05\TestFunctionTypehints\NonexistentClass
{
}
function bar(\_PhpScoperabd03f0baf05\TestFunctionTypehints\BarFunctionTypehints $bar) : array
{
}
function baz(...$bar) : \_PhpScoperabd03f0baf05\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParent()
{
}
function badCaseTypehints(\_PhpScoperabd03f0baf05\TestFunctionTypehints\fOOFunctionTypehints $foo) : \_PhpScoperabd03f0baf05\TestFunctionTypehints\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDoc(\_PhpScoperabd03f0baf05\TestFunctionTypehints\FooFunctionTypehints $foo) : \_PhpScoperabd03f0baf05\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDoc(\_PhpScoperabd03f0baf05\TestFunctionTypehints\FOOFunctionTypehints $foo) : \_PhpScoperabd03f0baf05\TestFunctionTypehints\FOOFunctionTypehints
{
}
function referencesTraitsInNative(\_PhpScoperabd03f0baf05\TestFunctionTypehints\SomeTrait $trait) : \_PhpScoperabd03f0baf05\TestFunctionTypehints\SomeTrait
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
