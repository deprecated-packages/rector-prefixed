<?php

namespace _PhpScopera143bcca66cb\MissingMethodReturnTypehint;

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
class Foo extends \_PhpScopera143bcca66cb\MissingMethodReturnTypehint\FooParent implements \_PhpScopera143bcca66cb\MissingMethodReturnTypehint\FooInterface
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
    public function returnsGenericInterface() : \_PhpScopera143bcca66cb\MissingMethodReturnTypehint\GenericInterface
    {
    }
    public function returnsNonGenericClass() : \_PhpScopera143bcca66cb\MissingMethodReturnTypehint\NonGenericClass
    {
    }
    public function returnsGenericClass() : \_PhpScopera143bcca66cb\MissingMethodReturnTypehint\GenericClass
    {
    }
}
