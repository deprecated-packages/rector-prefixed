<?php

namespace _PhpScoper88fe6e0ad041\DynamicMethodReturnTypesNamespace;

class EntityManager
{
    public function getByPrimary(string $className, int $id) : \_PhpScoper88fe6e0ad041\DynamicMethodReturnTypesNamespace\Entity
    {
        return new $className();
    }
    public static function createManagerForEntity(string $className) : self
    {
    }
}
class InheritedEntityManager extends \_PhpScoper88fe6e0ad041\DynamicMethodReturnTypesNamespace\EntityManager
{
}
class ComponentContainer implements \ArrayAccess
{
    public function offsetExists($offset)
    {
    }
    public function offsetGet($offset) : \_PhpScoper88fe6e0ad041\DynamicMethodReturnTypesNamespace\Entity
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
        $em = new \_PhpScoper88fe6e0ad041\DynamicMethodReturnTypesNamespace\EntityManager();
        $iem = new \_PhpScoper88fe6e0ad041\DynamicMethodReturnTypesNamespace\InheritedEntityManager();
        $container = new \_PhpScoper88fe6e0ad041\DynamicMethodReturnTypesNamespace\ComponentContainer();
        die;
    }
}
class FooWithoutConstructor
{
}
