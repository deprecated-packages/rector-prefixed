<?php

namespace _PhpScoperbd5d0c5f7638\NewStatic;

class NoConstructor
{
    public function doFoo()
    {
        $foo = new static();
    }
}
class NonFinalConstructor
{
    public function __construct()
    {
    }
    public function doFoo()
    {
        $foo = new static();
    }
}
final class NoConstructorInFinalClass
{
    public function doFoo()
    {
        $foo = new static();
    }
}
final class NonFinalConstructorInFinalClass
{
    public function __construct()
    {
    }
    public function doFoo()
    {
        $foo = new static();
    }
}
class FinalConstructorInNonFinalClass
{
    public final function __construct()
    {
    }
    public function doFoo()
    {
        $foo = new static();
    }
}
interface InterfaceWithConstructor
{
    public function __construct(int $i);
}
class ConstructorComingFromAnInterface implements \_PhpScoperbd5d0c5f7638\NewStatic\InterfaceWithConstructor
{
    public function __construct(int $i)
    {
    }
    public function doFoo()
    {
        $foo = new static(1);
    }
}
abstract class AbstractConstructor
{
    public abstract function __construct(string $s);
    public function doFoo()
    {
        new static('foo');
    }
}
class ClassExtendingAbstractConstructor extends \_PhpScoperbd5d0c5f7638\NewStatic\AbstractConstructor
{
    public function __construct(string $s)
    {
    }
    public function doBar()
    {
        new static('foo');
    }
}
