<?php

namespace _PhpScoperbd5d0c5f7638\Bug3915;

use function PHPStan\Analyser\assertType;
class HelloWorld
{
    public function sayHello() : void
    {
        $lengths = [0];
        foreach ([1] as $row) {
            $lengths[] = self::getInt();
        }
        \PHPStan\Analyser\assertType('array<int, int>&nonEmpty', $lengths);
    }
    public static function getInt() : int
    {
        return 5;
    }
}
