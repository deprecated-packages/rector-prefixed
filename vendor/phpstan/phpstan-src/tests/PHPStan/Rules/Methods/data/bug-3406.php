<?php

namespace _PhpScoper88fe6e0ad041\Bug3406;

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
final class ClassFoo extends \_PhpScoper88fe6e0ad041\Bug3406\AbstractFoo
{
    use TraitFoo;
}
