<?php

namespace _PhpScoper006a73f0e455\TestMethodTypehints;

class FooMethodTypehints
{
    function foo(\_PhpScoper006a73f0e455\TestMethodTypehints\FooMethodTypehints $foo, $bar, array $lorem) : \_PhpScoper006a73f0e455\TestMethodTypehints\NonexistentClass
    {
    }
    function bar(\_PhpScoper006a73f0e455\TestMethodTypehints\BarMethodTypehints $bar) : array
    {
    }
    function baz(...$bar) : \_PhpScoper006a73f0e455\TestMethodTypehints\FooMethodTypehints
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
    function parentWithoutParent(parent $parent) : \_PhpScoper006a73f0e455\parent
    {
    }
    /**
     * @param parent $parent
     * @return parent
     */
    function phpDocParentWithoutParent($parent)
    {
    }
    function badCaseTypehints(\_PhpScoper006a73f0e455\TestMethodTypehints\fOOMethodTypehints $foo) : \_PhpScoper006a73f0e455\TestMethodTypehints\fOOMethodTypehintS
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
    function badCaseInNativeAndPhpDoc(\_PhpScoper006a73f0e455\TestMethodTypehints\FooMethodTypehints $foo) : \_PhpScoper006a73f0e455\TestMethodTypehints\FooMethodTypehints
    {
    }
    /**
     * @param FooMethodTypehints $foo
     * @return FooMethodTypehints
     */
    function anotherBadCaseInNativeAndPhpDoc(\_PhpScoper006a73f0e455\TestMethodTypehints\FOOMethodTypehints $foo) : \_PhpScoper006a73f0e455\TestMethodTypehints\FOOMethodTypehints
    {
    }
    /**
     * @param array<NonexistentClass, AnotherNonexistentClass> $array
     */
    function unknownTypesInArrays(array $array)
    {
    }
}
