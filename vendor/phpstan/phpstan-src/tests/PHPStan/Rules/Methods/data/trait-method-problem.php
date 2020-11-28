<?php

namespace _PhpScoperabd03f0baf05\TraitProblem;

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
