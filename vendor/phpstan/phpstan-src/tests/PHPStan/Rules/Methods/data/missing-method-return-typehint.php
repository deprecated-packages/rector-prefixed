<?php

namespace _PhpScoperbd5d0c5f7638\MissingMethodReturnTypehint;

interface FooInterface
{
    public function getFoo($p1);
}
class FooParent
{
    public function getBar($p2)
    {
    }
}
class Foo extends \_PhpScoperbd5d0c5f7638\MissingMethodReturnTypehint\FooParent implements \_PhpScoperbd5d0c5f7638\MissingMethodReturnTypehint\FooInterface
{
    public function getFoo($p1)
    {
    }
    /**
     * @param $p2
     */
    public function getBar($p2)
    {
    }
    public function getBaz() : bool
    {
        return \false;
    }
    /**
     * @return \stdClass|array|int|null
     */
    public function unionTypeWithUnknownArrayValueTypehint()
    {
    }
}
/**
 * @template T
 * @template U
 */
interface GenericInterface
{
}
class NonGenericClass
{
}
/**
 * @template A
 * @template B
 */
class GenericClass
{
}
class Bar
{
    public function returnsGenericInterface() : \_PhpScoperbd5d0c5f7638\MissingMethodReturnTypehint\GenericInterface
    {
    }
    public function returnsNonGenericClass() : \_PhpScoperbd5d0c5f7638\MissingMethodReturnTypehint\NonGenericClass
    {
    }
    public function returnsGenericClass() : \_PhpScoperbd5d0c5f7638\MissingMethodReturnTypehint\GenericClass
    {
    }
}
