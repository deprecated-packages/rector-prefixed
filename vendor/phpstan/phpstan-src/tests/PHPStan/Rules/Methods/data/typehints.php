<?php

namespace _PhpScopera143bcca66cb\TestMethodTypehints;

class FooMethodTypehints
{
    function foo(\_PhpScopera143bcca66cb\TestMethodTypehints\FooMethodTypehints $foo, $bar, array $lorem) : \_PhpScopera143bcca66cb\TestMethodTypehints\NonexistentClass
    {
    }
    function bar(\_PhpScopera143bcca66cb\TestMethodTypehints\BarMethodTypehints $bar) : array
    {
    }
    function baz(...$bar) : \_PhpScopera143bcca66cb\TestMethodTypehints\FooMethodTypehints
    {
    }
    /**
     * @param FooMethodTypehints[] $foos
     * @param BarMethodTypehints[] $bars
     * @return BazMethodTypehints[]
     */
    function lorem($foos, $bars)
    {
    }
    /**
     * @param FooMethodTypehints[] $foos
     * @param BarMethodTypehints[] $bars
     * @return BazMethodTypehints[]
     */
    function ipsum(array $foos, array $bars) : array
    {
    }
    /**
     * @param FooMethodTypehints[] $foos
     * @param FooMethodTypehints|BarMethodTypehints[] $bars
     * @return self|BazMethodTypehints[]
     */
    function dolor(array $foos, array $bars) : array
    {
    }
    function parentWithoutParent(parent $parent) : \_PhpScopera143bcca66cb\parent
    {
    }
    /**
     * @param parent $parent
     * @return parent
     */
    function phpDocParentWithoutParent($parent)
    {
    }
    function badCaseTypehints(\_PhpScopera143bcca66cb\TestMethodTypehints\fOOMethodTypehints $foo) : \_PhpScopera143bcca66cb\TestMethodTypehints\fOOMethodTypehintS
    {
    }
    /**
     * @param fOOMethodTypehints|\STDClass $foo
     * @return fOOMethodTypehintS|\stdclass
     */
    function unionTypeBadCaseTypehints($foo)
    {
    }
    /**
     * @param FOOMethodTypehints $foo
     * @return FOOMethodTypehints
     */
    function badCaseInNativeAndPhpDoc(\_PhpScopera143bcca66cb\TestMethodTypehints\FooMethodTypehints $foo) : \_PhpScopera143bcca66cb\TestMethodTypehints\FooMethodTypehints
    {
    }
    /**
     * @param FooMethodTypehints $foo
     * @return FooMethodTypehints
     */
    function anotherBadCaseInNativeAndPhpDoc(\_PhpScopera143bcca66cb\TestMethodTypehints\FOOMethodTypehints $foo) : \_PhpScopera143bcca66cb\TestMethodTypehints\FOOMethodTypehints
    {
    }
    /**
     * @param array<NonexistentClass, AnotherNonexistentClass> $array
     */
    function unknownTypesInArrays(array $array)
    {
    }
}
