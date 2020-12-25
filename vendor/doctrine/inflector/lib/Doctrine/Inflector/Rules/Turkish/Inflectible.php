<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Turkish;

use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern;
use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Substitution;
use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation;
use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return Transformation[]
     */
    public static function getSingular() : iterable
    {
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/l[ae]r$/i'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/([eöiü][^aoıueöiü]{0,6})$/u'), '\\1ler'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/([aoıu][^aoıueöiü]{0,6})$/u'), '\\1lar'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('ben'), new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('biz')));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('sen'), new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('siz')));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('o'), new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('onlar')));
    }
}
