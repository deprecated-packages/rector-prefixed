<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Turkish;

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
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/l[ae]r$/i'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/([eöiü][^aoıueöiü]{0,6})$/u'), '\\1ler'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/([aoıu][^aoıueöiü]{0,6})$/u'), '\\1lar'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('ben'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('biz')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('sen'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('siz')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('o'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('onlar')));
    }
}
