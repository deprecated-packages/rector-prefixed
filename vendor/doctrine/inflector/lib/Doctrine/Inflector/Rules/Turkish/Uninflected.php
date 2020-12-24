<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Turkish;

use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern;
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
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('lunes'));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('rompecabezas'));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('crisis'));
    }
}
