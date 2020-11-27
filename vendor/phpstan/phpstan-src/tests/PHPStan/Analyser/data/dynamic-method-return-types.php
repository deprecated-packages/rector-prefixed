<?php

namespace _PhpScoperbd5d0c5f7638\DynamicMethodReturnTypesNamespace;

class EntityManager
{
    public function getByPrimary(string $className, int $id) : \_PhpScoperbd5d0c5f7638\DynamicMethodReturnTypesNamespace\Entity
    {
        return new $className();
    }
    public static function createManagerForEntity(string $className) : self
    {
    }
}
class InheritedEntityManager extends \_PhpScoperbd5d0c5f7638\DynamicMethodReturnTypesNamespace\EntityManager
{
}
class ComponentContainer implements \ArrayAccess
{
    public function offsetExists($offset)
    {
    }
    public function offsetGet($offset) : \_PhpScoperbd5d0c5f7638\DynamicMethodReturnTypesNamespace\Entity
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
        $em = new \_PhpScoperbd5d0c5f7638\DynamicMethodReturnTypesNamespace\EntityManager();
        $iem = new \_PhpScoperbd5d0c5f7638\DynamicMethodReturnTypesNamespace\InheritedEntityManager();
        $container = new \_PhpScoperbd5d0c5f7638\DynamicMethodReturnTypesNamespace\ComponentContainer();
        die;
    }
}
class FooWithoutConstructor
{
}
