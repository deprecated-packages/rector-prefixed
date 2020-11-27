<?php

namespace _PhpScoper006a73f0e455\MissingMethodReturnTypehint;

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
class Foo extends \_PhpScoper006a73f0e455\MissingMethodReturnTypehint\FooParent implements \_PhpScoper006a73f0e455\MissingMethodReturnTypehint\FooInterface
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
    public function returnsGenericInterface() : \_PhpScoper006a73f0e455\MissingMethodReturnTypehint\GenericInterface
    {
    }
    public function returnsNonGenericClass() : \_PhpScoper006a73f0e455\MissingMethodReturnTypehint\NonGenericClass
    {
    }
    public function returnsGenericClass() : \_PhpScoper006a73f0e455\MissingMethodReturnTypehint\GenericClass
    {
    }
}
