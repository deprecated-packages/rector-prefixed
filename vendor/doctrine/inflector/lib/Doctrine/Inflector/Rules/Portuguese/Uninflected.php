<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Portuguese;

use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern;
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
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('tórax'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('tênis'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('ônibus'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('lápis'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('fênix'));
    }
}
