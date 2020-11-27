<?php

namespace _PhpScopera143bcca66cb;

class FooFunctionTypehints
{
}
\class_alias('_PhpScopera143bcca66cb\\FooFunctionTypehints', 'FooFunctionTypehints', \false);
trait SomeTraitWithoutNamespace
{
}
function fooWithoutNamespace(\_PhpScopera143bcca66cb\FooFunctionTypehints $foo, $bar, array $lorem) : \_PhpScopera143bcca66cb\NonexistentClass
{
}
function barWithoutNamespace(\_PhpScopera143bcca66cb\BarFunctionTypehints $bar) : array
{
}
function bazWithoutNamespace(...$bar) : \_PhpScopera143bcca66cb\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParentWithoutNamespace()
{
}
function badCaseTypehintsWithoutNamespace(\_PhpScopera143bcca66cb\fOOFunctionTypehints $foo) : \_PhpScopera143bcca66cb\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDocWithoutNamespace(\_PhpScopera143bcca66cb\FooFunctionTypehints $foo) : \_PhpScopera143bcca66cb\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDocWithoutNamespace(\_PhpScopera143bcca66cb\FOOFunctionTypehints $foo) : \_PhpScopera143bcca66cb\FOOFunctionTypehints
{
}
function referencesTraitsInNativeWithoutNamespace(\_PhpScopera143bcca66cb\SomeTraitWithoutNamespace $trait) : \_PhpScopera143bcca66cb\SomeTraitWithoutNamespace
{
}
/**
 * @param SomeTraitWithoutNamespace $trait
 * @return SomeTraitWithoutNamespace
 */
function referencesTraitsInPhpDocWithoutNamespace($trait)
{
}
