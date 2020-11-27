<?php

namespace _PhpScoperbd5d0c5f7638\TestMethodTypehints;

class FooMethodTypehints
{
    function foo(\_PhpScoperbd5d0c5f7638\TestMethodTypehints\FooMethodTypehints $foo, $bar, array $lorem) : \_PhpScoperbd5d0c5f7638\TestMethodTypehints\NonexistentClass
    {
    }
    function bar(\_PhpScoperbd5d0c5f7638\TestMethodTypehints\BarMethodTypehints $bar) : array
    {
    }
    function baz(...$bar) : \_PhpScoperbd5d0c5f7638\TestMethodTypehints\FooMethodTypehints
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
    function parentWithoutParent(parent $parent) : \_PhpScoperbd5d0c5f7638\parent
    {
    }
    /**
     * @param parent $parent
     * @return parent
     */
    function phpDocParentWithoutParent($parent)
    {
    }
    function badCaseTypehints(\_PhpScoperbd5d0c5f7638\TestMethodTypehints\fOOMethodTypehints $foo) : \_PhpScoperbd5d0c5f7638\TestMethodTypehints\fOOMethodTypehintS
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
    function badCaseInNativeAndPhpDoc(\_PhpScoperbd5d0c5f7638\TestMethodTypehints\FooMethodTypehints $foo) : \_PhpScoperbd5d0c5f7638\TestMethodTypehints\FooMethodTypehints
    {
    }
    /**
     * @param FooMethodTypehints $foo
     * @return FooMethodTypehints
     */
    function anotherBadCaseInNativeAndPhpDoc(\_PhpScoperbd5d0c5f7638\TestMethodTypehints\FOOMethodTypehints $foo) : \_PhpScoperbd5d0c5f7638\TestMethodTypehints\FOOMethodTypehints
    {
    }
    /**
     * @param array<NonexistentClass, AnotherNonexistentClass> $array
     */
    function unknownTypesInArrays(array $array)
    {
    }
}
