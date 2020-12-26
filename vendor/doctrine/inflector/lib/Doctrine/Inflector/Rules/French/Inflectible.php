<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat\Doctrine\Inflector\Rules\French;

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
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/(b|cor|ém|gemm|soupir|trav|vant|vitr)aux$/'), '\\1ail'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/ails$/'), 'ail'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/(journ|chev)aux$/'), '\\1al'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/(bijou|caillou|chou|genou|hibou|joujou|pou|au|eu|eau)x$/'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/s$/'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/(s|x|z)$/'), '\\1'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/(b|cor|ém|gemm|soupir|trav|vant|vitr)ail$/'), '\\1aux'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/ail$/'), 'ails'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/al$/'), 'aux'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/(bleu|émeu|landau|lieu|pneu|sarrau)$/'), '\\1s'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/(bijou|caillou|chou|genou|hibou|joujou|pou|au|eu|eau)$/'), '\\1x'));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Pattern('/$/'), 's'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('monsieur'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('messieurs')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('madame'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('mesdames')));
        (yield new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('mademoiselle'), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Word('mesdemoiselles')));
    }
}
