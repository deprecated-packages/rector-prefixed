<?php

namespace _PhpScoper26e51eeacccf\Bug4076;

class Foo
{
    function test(int $x, int $y) : int
    {
        switch ($x) {
            case 0:
                return 0;
            case 1:
                if ($y == 2) {
                    // continue after the switch
                    break;
                }
            default:
                return 99;
        }
        return -1;
    }
}
