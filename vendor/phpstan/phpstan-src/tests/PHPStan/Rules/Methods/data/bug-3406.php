<?php

namespace _PhpScoperbd5d0c5f7638\Bug3406;

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
final class ClassFoo extends \_PhpScoperbd5d0c5f7638\Bug3406\AbstractFoo
{
    use TraitFoo;
}
