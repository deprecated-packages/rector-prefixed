<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat\Doctrine\Inflector\Rules\NorwegianBokmal;

use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return Transformation[]
     */
    public static function getSingular() : iterable
    {
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/re$/i'), 'r'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/er$/i'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/e$/i'), 'er'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/r$/i'), 're'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/$/'), 'er'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('konto'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('konti')));
    }
}
