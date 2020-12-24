<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Doctrine\Inflector\Rules\French;

use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Substitution;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return Transformation[]
     */
    public static function getSingular() : iterable
    {
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('/(b|cor|ém|gemm|soupir|trav|vant|vitr)aux$/'), '\\1ail'));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('/ails$/'), 'ail'));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('/(journ|chev)aux$/'), '\\1al'));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('/(bijou|caillou|chou|genou|hibou|joujou|pou|au|eu|eau)x$/'), '\\1'));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('/s$/'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('/(s|x|z)$/'), '\\1'));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('/(b|cor|ém|gemm|soupir|trav|vant|vitr)ail$/'), '\\1aux'));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('/ail$/'), 'ails'));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('/al$/'), 'aux'));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('/(bleu|émeu|landau|lieu|pneu|sarrau)$/'), '\\1s'));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('/(bijou|caillou|chou|genou|hibou|joujou|pou|au|eu|eau)$/'), '\\1x'));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformation(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Pattern('/$/'), 's'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Substitution(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Word('monsieur'), new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Word('messieurs')));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Substitution(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Word('madame'), new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Word('mesdames')));
        (yield new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Substitution(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Word('mademoiselle'), new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Word('mesdemoiselles')));
    }
}
