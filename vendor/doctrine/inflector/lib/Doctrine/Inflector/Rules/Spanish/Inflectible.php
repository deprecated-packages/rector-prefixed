<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Spanish;

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
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/ereses$/'), 'erés'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/iones$/'), 'ión'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/ces$/'), 'z'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/es$/'), ''));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/s$/'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/ú([sn])$/i'), '_PhpScoperbf340cb0be9d\\u\\1es'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/ó([sn])$/i'), '_PhpScoperbf340cb0be9d\\o\\1es'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/í([sn])$/i'), '_PhpScoperbf340cb0be9d\\i\\1es'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/é([sn])$/i'), '_PhpScoperbf340cb0be9d\\e\\1es'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/á([sn])$/i'), '_PhpScoperbf340cb0be9d\\a\\1es'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/z$/i'), 'ces'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/([aeiou]s)$/i'), '\\1'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/([^aeéiou])$/i'), '\\1es'));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Pattern('/$/'), 's'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('el'), new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('los')));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('papá'), new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('papás')));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('mamá'), new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('mamás')));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('sofá'), new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('sofás')));
        (yield new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('mes'), new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Word('meses')));
    }
}
