<?php

namespace _PhpScoper006a73f0e455\DynamicMethodReturnTypesNamespace;

class EntityManager
{
    public function getByPrimary(string $className, int $id) : \_PhpScoper006a73f0e455\DynamicMethodReturnTypesNamespace\Entity
    {
        return new $className();
    }
    public static function createManagerForEntity(string $className) : self
    {
    }
}
class InheritedEntityManager extends \_PhpScoper006a73f0e455\DynamicMethodReturnTypesNamespace\EntityManager
{
}
class ComponentContainer implements \ArrayAccess
{
    public function offsetExists($offset)
    {
    }
    public function offsetGet($offset) : \_PhpScoper006a73f0e455\DynamicMethodReturnTypesNamespace\Entity
    {
    }
    public function offsetSet($offset, $value)
    {
    }
    public function offsetUnset($offset)
    {
    }
}
class Foo
{
    public function __construct()
    {
    }
    public function doFoo()
    {
        $em = new \_PhpScoper006a73f0e455\DynamicMethodReturnTypesNamespace\EntityManager();
        $iem = new \_PhpScoper006a73f0e455\DynamicMethodReturnTypesNamespace\InheritedEntityManager();
        $container = new \_PhpScoper006a73f0e455\DynamicMethodReturnTypesNamespace\ComponentContainer();
        die;
    }
}
class FooWithoutConstructor
{
}
