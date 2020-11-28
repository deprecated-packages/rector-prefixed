<?php

namespace _PhpScoperabd03f0baf05\MissingMethodReturnTypehint;

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
class Foo extends \_PhpScoperabd03f0baf05\MissingMethodReturnTypehint\FooParent implements \_PhpScoperabd03f0baf05\MissingMethodReturnTypehint\FooInterface
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
    public function returnsGenericInterface() : \_PhpScoperabd03f0baf05\MissingMethodReturnTypehint\GenericInterface
    {
    }
    public function returnsNonGenericClass() : \_PhpScoperabd03f0baf05\MissingMethodReturnTypehint\NonGenericClass
    {
    }
    public function returnsGenericClass() : \_PhpScoperabd03f0baf05\MissingMethodReturnTypehint\GenericClass
    {
    }
}
