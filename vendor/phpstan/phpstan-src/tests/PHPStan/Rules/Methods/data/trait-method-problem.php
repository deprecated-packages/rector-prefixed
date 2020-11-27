<?php

namespace _PhpScoper88fe6e0ad041\TraitProblem;

trait X
{
    public static abstract function a(self $b) : void;
}
class Y
{
    use X;
    public static function a(self $b) : void
    {
    }
}
