<?php

namespace _PhpScopera143bcca66cb\Bug3406;

abstract class AbstractFoo
{
    public function myFoo() : void
    {
    }
    public function myBar() : void
    {
    }
}
trait TraitFoo
{
    public abstract function myFoo() : void;
    public function myBar() : void
    {
    }
}
final class ClassFoo extends \_PhpScopera143bcca66cb\Bug3406\AbstractFoo
{
    use TraitFoo;
}
