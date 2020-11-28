<?php

namespace _PhpScoperabd03f0baf05\Bug3406;

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
final class ClassFoo extends \_PhpScoperabd03f0baf05\Bug3406\AbstractFoo
{
    use TraitFoo;
}
