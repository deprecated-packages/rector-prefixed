<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Spanish;

use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Pattern;
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
        (yield new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Pattern('lunes'));
        (yield new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Pattern('rompecabezas'));
        (yield new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Pattern('crisis'));
    }
}
