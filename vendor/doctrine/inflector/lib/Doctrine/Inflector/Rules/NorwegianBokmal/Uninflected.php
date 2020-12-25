<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\NorwegianBokmal;

use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Pattern;
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
        (yield new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Pattern('barn'));
        (yield new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Pattern('fjell'));
        (yield new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Pattern('hus'));
    }
}
