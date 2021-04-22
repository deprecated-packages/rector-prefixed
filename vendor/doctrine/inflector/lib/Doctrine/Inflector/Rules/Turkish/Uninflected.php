<?php

declare (strict_types=1);
namespace RectorPrefix20210422\Doctrine\Inflector\Rules\Turkish;

use RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern;
final class Uninflected
{
    /**
     * @return mixed[]
     */
    public static function getSingular()
    {
        yield from self::getDefault();
    }
    /**
     * @return mixed[]
     */
    public static function getPlural()
    {
        yield from self::getDefault();
    }
    /**
     * @return mixed[]
     */
    private static function getDefault()
    {
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern('lunes'));
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern('rompecabezas'));
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern('crisis'));
    }
}
