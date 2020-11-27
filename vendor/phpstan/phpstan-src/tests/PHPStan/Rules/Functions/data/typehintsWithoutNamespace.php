<?php

namespace _PhpScoperbd5d0c5f7638;

class FooFunctionTypehints
{
}
\class_alias('_PhpScoperbd5d0c5f7638\\FooFunctionTypehints', 'FooFunctionTypehints', \false);
trait SomeTraitWithoutNamespace
{
}
function fooWithoutNamespace(\_PhpScoperbd5d0c5f7638\FooFunctionTypehints $foo, $bar, array $lorem) : \_PhpScoperbd5d0c5f7638\NonexistentClass
{
}
function barWithoutNamespace(\_PhpScoperbd5d0c5f7638\BarFunctionTypehints $bar) : array
{
}
function bazWithoutNamespace(...$bar) : \_PhpScoperbd5d0c5f7638\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParentWithoutNamespace()
{
}
function badCaseTypehintsWithoutNamespace(\_PhpScoperbd5d0c5f7638\fOOFunctionTypehints $foo) : \_PhpScoperbd5d0c5f7638\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDocWithoutNamespace(\_PhpScoperbd5d0c5f7638\FooFunctionTypehints $foo) : \_PhpScoperbd5d0c5f7638\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDocWithoutNamespace(\_PhpScoperbd5d0c5f7638\FOOFunctionTypehints $foo) : \_PhpScoperbd5d0c5f7638\FOOFunctionTypehints
{
}
function referencesTraitsInNativeWithoutNamespace(\_PhpScoperbd5d0c5f7638\SomeTraitWithoutNamespace $trait) : \_PhpScoperbd5d0c5f7638\SomeTraitWithoutNamespace
{
}
/**
 * @param SomeTraitWithoutNamespace $trait
 * @return SomeTraitWithoutNamespace
 */
function referencesTraitsInPhpDocWithoutNamespace($trait)
{
}
