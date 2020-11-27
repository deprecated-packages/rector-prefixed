<?php

namespace _PhpScoper006a73f0e455\MissingMethodParameterTypehint;

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
class Foo extends \_PhpScoper006a73f0e455\MissingMethodParameterTypehint\FooParent implements \_PhpScoper006a73f0e455\MissingMethodParameterTypehint\FooInterface
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
    public function acceptsGenericInterface(\_PhpScoper006a73f0e455\MissingMethodParameterTypehint\GenericInterface $i)
    {
    }
    public function acceptsNonGenericClass(\_PhpScoper006a73f0e455\MissingMethodParameterTypehint\NonGenericClass $c)
    {
    }
    public function acceptsGenericClass(\_PhpScoper006a73f0e455\MissingMethodParameterTypehint\GenericClass $c)
    {
    }
}
class CollectionIterableAndGeneric
{
    public function acceptsCollection(\_PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection $collection) : void
    {
    }
    /**
     * @param \DoctrineIntersectionTypeIsSupertypeOf\Collection<FooInterface> $collection
     */
    public function acceptsCollection2(\_PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection $collection) : void
    {
    }
    /**
     * @param \DoctrineIntersectionTypeIsSupertypeOf\Collection<int, FooInterface> $collection
     */
    public function acceptsCollection3(\_PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection $collection) : void
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
