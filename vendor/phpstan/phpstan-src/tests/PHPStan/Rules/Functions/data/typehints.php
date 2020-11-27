<?php

namespace _PhpScoper26e51eeacccf\TestFunctionTypehints;

class FooFunctionTypehints
{
}
trait SomeTrait
{
}
function foo(\_PhpScoper26e51eeacccf\TestFunctionTypehints\FooFunctionTypehints $foo, $bar, array $lorem) : \_PhpScoper26e51eeacccf\TestFunctionTypehints\NonexistentClass
{
}
function bar(\_PhpScoper26e51eeacccf\TestFunctionTypehints\BarFunctionTypehints $bar) : array
{
}
function baz(...$bar) : \_PhpScoper26e51eeacccf\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParent()
{
}
function badCaseTypehints(\_PhpScoper26e51eeacccf\TestFunctionTypehints\fOOFunctionTypehints $foo) : \_PhpScoper26e51eeacccf\TestFunctionTypehints\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDoc(\_PhpScoper26e51eeacccf\TestFunctionTypehints\FooFunctionTypehints $foo) : \_PhpScoper26e51eeacccf\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDoc(\_PhpScoper26e51eeacccf\TestFunctionTypehints\FOOFunctionTypehints $foo) : \_PhpScoper26e51eeacccf\TestFunctionTypehints\FOOFunctionTypehints
{
}
function referencesTraitsInNative(\_PhpScoper26e51eeacccf\TestFunctionTypehints\SomeTrait $trait) : \_PhpScoper26e51eeacccf\TestFunctionTypehints\SomeTrait
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
