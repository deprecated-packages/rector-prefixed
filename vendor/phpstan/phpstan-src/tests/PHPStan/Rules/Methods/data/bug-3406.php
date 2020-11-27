<?php

namespace _PhpScoper006a73f0e455\Bug3406;

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
final class ClassFoo extends \_PhpScoper006a73f0e455\Bug3406\AbstractFoo
{
    use TraitFoo;
}
