<?php

namespace _PhpScoperbd5d0c5f7638\TraitProblem;

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
