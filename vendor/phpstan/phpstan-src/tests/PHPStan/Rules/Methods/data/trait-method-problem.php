<?php

namespace _PhpScoper26e51eeacccf\TraitProblem;

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
