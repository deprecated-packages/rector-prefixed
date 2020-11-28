<?php

namespace _PhpScoperabd03f0baf05\DynamicMethodReturnTypesNamespace;

class EntityManager
{
    public function getByPrimary(string $className, int $id) : \_PhpScoperabd03f0baf05\DynamicMethodReturnTypesNamespace\Entity
    {
        return new $className();
    }
    public static function createManagerForEntity(string $className) : self
    {
    }
}
class InheritedEntityManager extends \_PhpScoperabd03f0baf05\DynamicMethodReturnTypesNamespace\EntityManager
{
}
class ComponentContainer implements \ArrayAccess
{
    public function offsetExists($offset)
    {
    }
    public function offsetGet($offset) : \_PhpScoperabd03f0baf05\DynamicMethodReturnTypesNamespace\Entity
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
        $em = new \_PhpScoperabd03f0baf05\DynamicMethodReturnTypesNamespace\EntityManager();
        $iem = new \_PhpScoperabd03f0baf05\DynamicMethodReturnTypesNamespace\InheritedEntityManager();
        $container = new \_PhpScoperabd03f0baf05\DynamicMethodReturnTypesNamespace\ComponentContainer();
        die;
    }
}
class FooWithoutConstructor
{
}
