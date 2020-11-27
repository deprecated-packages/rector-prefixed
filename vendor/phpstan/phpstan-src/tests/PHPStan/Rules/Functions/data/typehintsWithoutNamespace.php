<?php

namespace _PhpScoper88fe6e0ad041;

class FooFunctionTypehints
{
}
\class_alias('_PhpScoper88fe6e0ad041\\FooFunctionTypehints', 'FooFunctionTypehints', \false);
trait SomeTraitWithoutNamespace
{
}
function fooWithoutNamespace(\_PhpScoper88fe6e0ad041\FooFunctionTypehints $foo, $bar, array $lorem) : \_PhpScoper88fe6e0ad041\NonexistentClass
{
}
function barWithoutNamespace(\_PhpScoper88fe6e0ad041\BarFunctionTypehints $bar) : array
{
}
function bazWithoutNamespace(...$bar) : \_PhpScoper88fe6e0ad041\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParentWithoutNamespace()
{
}
function badCaseTypehintsWithoutNamespace(\_PhpScoper88fe6e0ad041\fOOFunctionTypehints $foo) : \_PhpScoper88fe6e0ad041\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDocWithoutNamespace(\_PhpScoper88fe6e0ad041\FooFunctionTypehints $foo) : \_PhpScoper88fe6e0ad041\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDocWithoutNamespace(\_PhpScoper88fe6e0ad041\FOOFunctionTypehints $foo) : \_PhpScoper88fe6e0ad041\FOOFunctionTypehints
{
}
function referencesTraitsInNativeWithoutNamespace(\_PhpScoper88fe6e0ad041\SomeTraitWithoutNamespace $trait) : \_PhpScoper88fe6e0ad041\SomeTraitWithoutNamespace
{
}
/**
 * @param SomeTraitWithoutNamespace $trait
 * @return SomeTraitWithoutNamespace
 */
function referencesTraitsInPhpDocWithoutNamespace($trait)
{
}
