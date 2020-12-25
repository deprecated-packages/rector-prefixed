<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\NorwegianBokmal;

use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern;
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
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('barn'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('fjell'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('hus'));
    }
}
