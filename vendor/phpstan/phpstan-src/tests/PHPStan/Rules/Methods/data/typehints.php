<?php

namespace _PhpScoperabd03f0baf05\TestMethodTypehints;

class FooMethodTypehints
{
    function foo(\_PhpScoperabd03f0baf05\TestMethodTypehints\FooMethodTypehints $foo, $bar, array $lorem) : \_PhpScoperabd03f0baf05\TestMethodTypehints\NonexistentClass
    {
    }
    function bar(\_PhpScoperabd03f0baf05\TestMethodTypehints\BarMethodTypehints $bar) : array
    {
    }
    function baz(...$bar) : \_PhpScoperabd03f0baf05\TestMethodTypehints\FooMethodTypehints
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
    function parentWithoutParent(parent $parent) : \_PhpScoperabd03f0baf05\parent
    {
    }
    /**
     * @param parent $parent
     * @return parent
     */
    function phpDocParentWithoutParent($parent)
    {
    }
    function badCaseTypehints(\_PhpScoperabd03f0baf05\TestMethodTypehints\fOOMethodTypehints $foo) : \_PhpScoperabd03f0baf05\TestMethodTypehints\fOOMethodTypehintS
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
    function badCaseInNativeAndPhpDoc(\_PhpScoperabd03f0baf05\TestMethodTypehints\FooMethodTypehints $foo) : \_PhpScoperabd03f0baf05\TestMethodTypehints\FooMethodTypehints
    {
    }
    /**
     * @param FooMethodTypehints $foo
     * @return FooMethodTypehints
     */
    function anotherBadCaseInNativeAndPhpDoc(\_PhpScoperabd03f0baf05\TestMethodTypehints\FOOMethodTypehints $foo) : \_PhpScoperabd03f0baf05\TestMethodTypehints\FOOMethodTypehints
    {
    }
    /**
     * @param array<NonexistentClass, AnotherNonexistentClass> $array
     */
    function unknownTypesInArrays(array $array)
    {
    }
}
