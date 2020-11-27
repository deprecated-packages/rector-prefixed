<?php

namespace _PhpScoper26e51eeacccf;

class FooFunctionTypehints
{
}
\class_alias('_PhpScoper26e51eeacccf\\FooFunctionTypehints', 'FooFunctionTypehints', \false);
trait SomeTraitWithoutNamespace
{
}
function fooWithoutNamespace(\_PhpScoper26e51eeacccf\FooFunctionTypehints $foo, $bar, array $lorem) : \_PhpScoper26e51eeacccf\NonexistentClass
{
}
function barWithoutNamespace(\_PhpScoper26e51eeacccf\BarFunctionTypehints $bar) : array
{
}
function bazWithoutNamespace(...$bar) : \_PhpScoper26e51eeacccf\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParentWithoutNamespace()
{
}
function badCaseTypehintsWithoutNamespace(\_PhpScoper26e51eeacccf\fOOFunctionTypehints $foo) : \_PhpScoper26e51eeacccf\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDocWithoutNamespace(\_PhpScoper26e51eeacccf\FooFunctionTypehints $foo) : \_PhpScoper26e51eeacccf\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDocWithoutNamespace(\_PhpScoper26e51eeacccf\FOOFunctionTypehints $foo) : \_PhpScoper26e51eeacccf\FOOFunctionTypehints
{
}
function referencesTraitsInNativeWithoutNamespace(\_PhpScoper26e51eeacccf\SomeTraitWithoutNamespace $trait) : \_PhpScoper26e51eeacccf\SomeTraitWithoutNamespace
{
}
/**
 * @param SomeTraitWithoutNamespace $trait
 * @return SomeTraitWithoutNamespace
 */
function referencesTraitsInPhpDocWithoutNamespace($trait)
{
}
