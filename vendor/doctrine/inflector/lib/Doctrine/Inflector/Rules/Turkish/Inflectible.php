<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Turkish;

use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern;
use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitution;
use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation;
use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return Transformation[]
     */
    public static function getSingular() : iterable
    {
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/l[ae]r$/i'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/([eöiü][^aoıueöiü]{0,6})$/u'), '\\1ler'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/([aoıu][^aoıueöiü]{0,6})$/u'), '\\1lar'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('ben'), new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('biz')));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('sen'), new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('siz')));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('o'), new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('onlar')));
    }
}
