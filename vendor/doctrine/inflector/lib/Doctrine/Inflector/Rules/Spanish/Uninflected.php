<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Spanish;

use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern;
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
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('lunes'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('rompecabezas'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('crisis'));
    }
}
