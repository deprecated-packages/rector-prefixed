<?php

namespace _PhpScoperbd5d0c5f7638\Bug3406_2;

trait AbstractTrait
{
    public abstract function test() : void;
}
trait ImplTrait
{
    public function test() : void
    {
    }
}
class Test
{
    use AbstractTrait;
    use ImplTrait;
}
class Test2
{
    use ImplTrait;
    use AbstractTrait;
}
