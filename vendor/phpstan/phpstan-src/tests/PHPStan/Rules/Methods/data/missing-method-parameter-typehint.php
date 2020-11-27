<?php

namespace _PhpScoper88fe6e0ad041\MissingMethodParameterTypehint;

interface FooInterface
{
    public function getFoo($p1) : void;
}
class FooParent
{
    public function getBar($p2)
    {
    }
}
class Foo extends \_PhpScoper88fe6e0ad041\MissingMethodParameterTypehint\FooParent implements \_PhpScoper88fe6e0ad041\MissingMethodParameterTypehint\FooInterface
{
    public function getFoo($p1) : void
    {
    }
    /**
     * @param $p2
     */
    public function getBar($p2)
    {
    }
    /**
     * @param $p3
     * @param int $p4
     */
    public function getBaz($p3, $p4) : bool
    {
        return \false;
    }
    /**
     * @param mixed $p5
     */
    public function getFooBar($p5) : bool
    {
        return \false;
    }
    /**
     * @param \stdClass|array|int|null $a
     */
    public function unionTypeWithUnknownArrayValueTypehint($a)
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
    public function acceptsGenericInterface(\_PhpScoper88fe6e0ad041\MissingMethodParameterTypehint\GenericInterface $i)
    {
    }
    public function acceptsNonGenericClass(\_PhpScoper88fe6e0ad041\MissingMethodParameterTypehint\NonGenericClass $c)
    {
    }
    public function acceptsGenericClass(\_PhpScoper88fe6e0ad041\MissingMethodParameterTypehint\GenericClass $c)
    {
    }
}
class CollectionIterableAndGeneric
{
    public function acceptsCollection(\_PhpScoper88fe6e0ad041\DoctrineIntersectionTypeIsSupertypeOf\Collection $collection) : void
    {
    }
    /**
     * @param \DoctrineIntersectionTypeIsSupertypeOf\Collection<FooInterface> $collection
     */
    public function acceptsCollection2(\_PhpScoper88fe6e0ad041\DoctrineIntersectionTypeIsSupertypeOf\Collection $collection) : void
    {
    }
    /**
     * @param \DoctrineIntersectionTypeIsSupertypeOf\Collection<int, FooInterface> $collection
     */
    public function acceptsCollection3(\_PhpScoper88fe6e0ad041\DoctrineIntersectionTypeIsSupertypeOf\Collection $collection) : void
    {
    }
}
class TraversableInTemplateBound
{
    /**
     * @template T of \Iterator
     * @param T $it
     */
    public function doFoo($it)
    {
    }
}
class GenericClassInTemplateBound
{
    /**
     * @template T of GenericClass
     * @param T $obj
     */
    public function doFoo($obj)
    {
    }
}
class SerializableImpl implements \Serializable
{
    public function serialize() : string
    {
        return \serialize([]);
    }
    public function unserialize($serialized) : void
    {
    }
}
