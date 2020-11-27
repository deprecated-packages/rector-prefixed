<?php

namespace _PhpScoper88fe6e0ad041\TestMethodTypehints;

class FooMethodTypehints
{
    function foo(\_PhpScoper88fe6e0ad041\TestMethodTypehints\FooMethodTypehints $foo, $bar, array $lorem) : \_PhpScoper88fe6e0ad041\TestMethodTypehints\NonexistentClass
    {
    }
    function bar(\_PhpScoper88fe6e0ad041\TestMethodTypehints\BarMethodTypehints $bar) : array
    {
    }
    function baz(...$bar) : \_PhpScoper88fe6e0ad041\TestMethodTypehints\FooMethodTypehints
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
    function parentWithoutParent(parent $parent) : \_PhpScoper88fe6e0ad041\parent
    {
    }
    /**
     * @param parent $parent
     * @return parent
     */
    function phpDocParentWithoutParent($parent)
    {
    }
    function badCaseTypehints(\_PhpScoper88fe6e0ad041\TestMethodTypehints\fOOMethodTypehints $foo) : \_PhpScoper88fe6e0ad041\TestMethodTypehints\fOOMethodTypehintS
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
    function badCaseInNativeAndPhpDoc(\_PhpScoper88fe6e0ad041\TestMethodTypehints\FooMethodTypehints $foo) : \_PhpScoper88fe6e0ad041\TestMethodTypehints\FooMethodTypehints
    {
    }
    /**
     * @param FooMethodTypehints $foo
     * @return FooMethodTypehints
     */
    function anotherBadCaseInNativeAndPhpDoc(\_PhpScoper88fe6e0ad041\TestMethodTypehints\FOOMethodTypehints $foo) : \_PhpScoper88fe6e0ad041\TestMethodTypehints\FOOMethodTypehints
    {
    }
    /**
     * @param array<NonexistentClass, AnotherNonexistentClass> $array
     */
    function unknownTypesInArrays(array $array)
    {
    }
}
