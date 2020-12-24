<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal;

use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Pattern;
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
        (yield new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Pattern('barn'));
        (yield new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Pattern('fjell'));
        (yield new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Pattern('hus'));
    }
}
