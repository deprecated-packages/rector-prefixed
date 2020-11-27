<?php

namespace _PhpScoper006a73f0e455;

class FooFunctionTypehints
{
}
\class_alias('_PhpScoper006a73f0e455\\FooFunctionTypehints', 'FooFunctionTypehints', \false);
trait SomeTraitWithoutNamespace
{
}
function fooWithoutNamespace(\_PhpScoper006a73f0e455\FooFunctionTypehints $foo, $bar, array $lorem) : \_PhpScoper006a73f0e455\NonexistentClass
{
}
function barWithoutNamespace(\_PhpScoper006a73f0e455\BarFunctionTypehints $bar) : array
{
}
function bazWithoutNamespace(...$bar) : \_PhpScoper006a73f0e455\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParentWithoutNamespace()
{
}
function badCaseTypehintsWithoutNamespace(\_PhpScoper006a73f0e455\fOOFunctionTypehints $foo) : \_PhpScoper006a73f0e455\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDocWithoutNamespace(\_PhpScoper006a73f0e455\FooFunctionTypehints $foo) : \_PhpScoper006a73f0e455\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDocWithoutNamespace(\_PhpScoper006a73f0e455\FOOFunctionTypehints $foo) : \_PhpScoper006a73f0e455\FOOFunctionTypehints
{
}
function referencesTraitsInNativeWithoutNamespace(\_PhpScoper006a73f0e455\SomeTraitWithoutNamespace $trait) : \_PhpScoper006a73f0e455\SomeTraitWithoutNamespace
{
}
/**
 * @param SomeTraitWithoutNamespace $trait
 * @return SomeTraitWithoutNamespace
 */
function referencesTraitsInPhpDocWithoutNamespace($trait)
{
}
