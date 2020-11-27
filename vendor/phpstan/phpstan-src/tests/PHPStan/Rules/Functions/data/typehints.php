<?php

namespace _PhpScoper006a73f0e455\TestFunctionTypehints;

class FooFunctionTypehints
{
}
trait SomeTrait
{
}
function foo(\_PhpScoper006a73f0e455\TestFunctionTypehints\FooFunctionTypehints $foo, $bar, array $lorem) : \_PhpScoper006a73f0e455\TestFunctionTypehints\NonexistentClass
{
}
function bar(\_PhpScoper006a73f0e455\TestFunctionTypehints\BarFunctionTypehints $bar) : array
{
}
function baz(...$bar) : \_PhpScoper006a73f0e455\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParent()
{
}
function badCaseTypehints(\_PhpScoper006a73f0e455\TestFunctionTypehints\fOOFunctionTypehints $foo) : \_PhpScoper006a73f0e455\TestFunctionTypehints\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDoc(\_PhpScoper006a73f0e455\TestFunctionTypehints\FooFunctionTypehints $foo) : \_PhpScoper006a73f0e455\TestFunctionTypehints\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDoc(\_PhpScoper006a73f0e455\TestFunctionTypehints\FOOFunctionTypehints $foo) : \_PhpScoper006a73f0e455\TestFunctionTypehints\FOOFunctionTypehints
{
}
function referencesTraitsInNative(\_PhpScoper006a73f0e455\TestFunctionTypehints\SomeTrait $trait) : \_PhpScoper006a73f0e455\TestFunctionTypehints\SomeTrait
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
