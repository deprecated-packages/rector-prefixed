<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Spanish;

use _PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern;
use _PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Substitution;
use _PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation;
use _PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return Transformation[]
     */
    public static function getSingular() : iterable
    {
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/ereses$/'), 'erés'));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/iones$/'), 'ión'));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/ces$/'), 'z'));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/es$/'), ''));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/s$/'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/ú([sn])$/i'), '_PhpScoper006a73f0e455\\u\\1es'));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/ó([sn])$/i'), '_PhpScoper006a73f0e455\\o\\1es'));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/í([sn])$/i'), '_PhpScoper006a73f0e455\\i\\1es'));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/é([sn])$/i'), '_PhpScoper006a73f0e455\\e\\1es'));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/á([sn])$/i'), '_PhpScoper006a73f0e455\\a\\1es'));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/z$/i'), 'ces'));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/([aeiou]s)$/i'), '\\1'));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/([^aeéiou])$/i'), '\\1es'));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Transformation(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Pattern('/$/'), 's'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Word('el'), new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Word('los')));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Word('papá'), new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Word('papás')));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Word('mamá'), new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Word('mamás')));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Word('sofá'), new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Word('sofás')));
        (yield new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Substitution(new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Word('mes'), new \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Word('meses')));
    }
}
