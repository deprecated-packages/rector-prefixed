<?php

namespace _PhpScoperabd03f0baf05;

class FooFunctionTypehints
{
}
\class_alias('_PhpScoperabd03f0baf05\\FooFunctionTypehints', 'FooFunctionTypehints', \false);
trait SomeTraitWithoutNamespace
{
}
function fooWithoutNamespace(\_PhpScoperabd03f0baf05\FooFunctionTypehints $foo, $bar, array $lorem) : \_PhpScoperabd03f0baf05\NonexistentClass
{
}
function barWithoutNamespace(\_PhpScoperabd03f0baf05\BarFunctionTypehints $bar) : array
{
}
function bazWithoutNamespace(...$bar) : \_PhpScoperabd03f0baf05\FooFunctionTypehints
{
}
/**
 * @return parent
 */
function returnParentWithoutNamespace()
{
}
function badCaseTypehintsWithoutNamespace(\_PhpScoperabd03f0baf05\fOOFunctionTypehints $foo) : \_PhpScoperabd03f0baf05\fOOFunctionTypehintS
{
}
/**
 * @param FOOFunctionTypehints $foo
 * @return FOOFunctionTypehints
 */
function badCaseInNativeAndPhpDocWithoutNamespace(\_PhpScoperabd03f0baf05\FooFunctionTypehints $foo) : \_PhpScoperabd03f0baf05\FooFunctionTypehints
{
}
/**
 * @param FooFunctionTypehints $foo
 * @return FooFunctionTypehints
 */
function anotherBadCaseInNativeAndPhpDocWithoutNamespace(\_PhpScoperabd03f0baf05\FOOFunctionTypehints $foo) : \_PhpScoperabd03f0baf05\FOOFunctionTypehints
{
}
function referencesTraitsInNativeWithoutNamespace(\_PhpScoperabd03f0baf05\SomeTraitWithoutNamespace $trait) : \_PhpScoperabd03f0baf05\SomeTraitWithoutNamespace
{
}
/**
 * @param SomeTraitWithoutNamespace $trait
 * @return SomeTraitWithoutNamespace
 */
function referencesTraitsInPhpDocWithoutNamespace($trait)
{
}
