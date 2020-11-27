<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Spanish;

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
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/ereses$/'), 'erés'));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/iones$/'), 'ión'));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/ces$/'), 'z'));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/es$/'), ''));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/s$/'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/ú([sn])$/i'), '_PhpScopera143bcca66cb\\u\\1es'));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/ó([sn])$/i'), '_PhpScopera143bcca66cb\\o\\1es'));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/í([sn])$/i'), '_PhpScopera143bcca66cb\\i\\1es'));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/é([sn])$/i'), '_PhpScopera143bcca66cb\\e\\1es'));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/á([sn])$/i'), '_PhpScopera143bcca66cb\\a\\1es'));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/z$/i'), 'ces'));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/([aeiou]s)$/i'), '\\1'));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/([^aeéiou])$/i'), '\\1es'));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformation(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Pattern('/$/'), 's'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitution(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('el'), new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('los')));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitution(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('papá'), new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('papás')));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitution(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('mamá'), new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('mamás')));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitution(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('sofá'), new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('sofás')));
        (yield new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitution(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('mes'), new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Word('meses')));
    }
}
