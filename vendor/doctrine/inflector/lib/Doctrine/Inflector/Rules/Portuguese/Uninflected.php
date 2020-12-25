<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\Portuguese;

use _PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\Pattern;
final class Uninflected
{
    /**
     * @return Pattern[]
     */
    public static function getSingular() : iterable
    {
        yield from self::getDefault();
    }
    /**
     * @return Pattern[]
     */
    public static function getPlural() : iterable
    {
        yield from self::getDefault();
    }
    /**
     * @return Pattern[]
     */
    private static function getDefault() : iterable
    {
        (yield new \_PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\Pattern('tórax'));
        (yield new \_PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\Pattern('tênis'));
        (yield new \_PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\Pattern('ônibus'));
        (yield new \_PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\Pattern('lápis'));
        (yield new \_PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\Pattern('fênix'));
    }
}
