<?php

declare (strict_types=1);
namespace RectorPrefix20210423\Doctrine\Inflector\Rules\French;

use RectorPrefix20210423\Doctrine\Inflector\Rules\Pattern;
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
        (yield new \RectorPrefix20210423\Doctrine\Inflector\Rules\Pattern(''));
    }
}
