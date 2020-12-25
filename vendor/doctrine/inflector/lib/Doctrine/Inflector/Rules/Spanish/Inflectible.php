<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Spanish;

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
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/ereses$/'), 'erés'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/iones$/'), 'ión'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/ces$/'), 'z'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/es$/'), ''));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/s$/'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/ú([sn])$/i'), '_PhpScoperfce0de0de1ce\\u\\1es'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/ó([sn])$/i'), '_PhpScoperfce0de0de1ce\\o\\1es'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/í([sn])$/i'), '_PhpScoperfce0de0de1ce\\i\\1es'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/é([sn])$/i'), '_PhpScoperfce0de0de1ce\\e\\1es'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/á([sn])$/i'), '_PhpScoperfce0de0de1ce\\a\\1es'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/z$/i'), 'ces'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/([aeiou]s)$/i'), '\\1'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/([^aeéiou])$/i'), '\\1es'));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Pattern('/$/'), 's'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('el'), new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('los')));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('papá'), new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('papás')));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('mamá'), new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('mamás')));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('sofá'), new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('sofás')));
        (yield new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('mes'), new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Word('meses')));
    }
}
