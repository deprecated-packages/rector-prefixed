<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Turkish;

use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern;
use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitution;
use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation;
use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return Transformation[]
     */
    public static function getSingular() : iterable
    {
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/l[ae]r$/i'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/([eöiü][^aoıueöiü]{0,6})$/u'), '\\1ler'));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/([aoıu][^aoıueöiü]{0,6})$/u'), '\\1lar'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitution(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('ben'), new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('biz')));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitution(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('sen'), new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('siz')));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitution(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('o'), new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('onlar')));
    }
}
