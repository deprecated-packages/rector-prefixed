<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\French;

use _PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern;
use _PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Substitution;
use _PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation;
use _PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return Transformation[]
     */
    public static function getSingular() : iterable
    {
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern('/(b|cor|ém|gemm|soupir|trav|vant|vitr)aux$/'), '\\1ail'));
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern('/ails$/'), 'ail'));
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern('/(journ|chev)aux$/'), '\\1al'));
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern('/(bijou|caillou|chou|genou|hibou|joujou|pou|au|eu|eau)x$/'), '\\1'));
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern('/s$/'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern('/(s|x|z)$/'), '\\1'));
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern('/(b|cor|ém|gemm|soupir|trav|vant|vitr)ail$/'), '\\1aux'));
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern('/ail$/'), 'ails'));
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern('/al$/'), 'aux'));
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern('/(bleu|émeu|landau|lieu|pneu|sarrau)$/'), '\\1s'));
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern('/(bijou|caillou|chou|genou|hibou|joujou|pou|au|eu|eau)$/'), '\\1x'));
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Pattern('/$/'), 's'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Word('monsieur'), new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Word('messieurs')));
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Word('madame'), new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Word('mesdames')));
        (yield new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Word('mademoiselle'), new \_PhpScoper88fe6e0ad041\Doctrine\Inflector\Rules\Word('mesdemoiselles')));
    }
}