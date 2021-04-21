<?php

declare (strict_types=1);
namespace RectorPrefix20210421\Doctrine\Inflector\Rules\Portuguese;

use RectorPrefix20210421\Doctrine\Inflector\Rules\Pattern;
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
        (yield new \RectorPrefix20210421\Doctrine\Inflector\Rules\Pattern('tórax'));
        (yield new \RectorPrefix20210421\Doctrine\Inflector\Rules\Pattern('tênis'));
        (yield new \RectorPrefix20210421\Doctrine\Inflector\Rules\Pattern('ônibus'));
        (yield new \RectorPrefix20210421\Doctrine\Inflector\Rules\Pattern('lápis'));
        (yield new \RectorPrefix20210421\Doctrine\Inflector\Rules\Pattern('fênix'));
    }
}
