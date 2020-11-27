<?php

namespace _PhpScoper26e51eeacccf\MethodSignature;

class Foo
{
    /**
     * @param int $value
     */
    public static function doFoo($value)
    {
    }
}
class Bar extends \_PhpScoper26e51eeacccf\MethodSignature\Foo
{
    /**
     * @param string $value
     */
    public static function doFoo($value)
    {
    }
}
