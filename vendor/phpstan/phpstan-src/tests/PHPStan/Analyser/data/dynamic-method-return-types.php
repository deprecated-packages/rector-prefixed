<?php

namespace _PhpScopera143bcca66cb\DynamicMethodReturnTypesNamespace;

class EntityManager
{
    public function getByPrimary(string $className, int $id) : \_PhpScopera143bcca66cb\DynamicMethodReturnTypesNamespace\Entity
    {
        return new $className();
    }
    public static function createManagerForEntity(string $className) : self
    {
    }
}
class InheritedEntityManager extends \_PhpScopera143bcca66cb\DynamicMethodReturnTypesNamespace\EntityManager
{
}
class ComponentContainer implements \ArrayAccess
{
    public function offsetExists($offset)
    {
    }
    public function offsetGet($offset) : \_PhpScopera143bcca66cb\DynamicMethodReturnTypesNamespace\Entity
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
        $em = new \_PhpScopera143bcca66cb\DynamicMethodReturnTypesNamespace\EntityManager();
        $iem = new \_PhpScopera143bcca66cb\DynamicMethodReturnTypesNamespace\InheritedEntityManager();
        $container = new \_PhpScopera143bcca66cb\DynamicMethodReturnTypesNamespace\ComponentContainer();
        die;
    }
}
class FooWithoutConstructor
{
}
