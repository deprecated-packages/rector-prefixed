<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Spanish;

use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return Transformation[]
     */
    public static function getSingular() : iterable
    {
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/ereses$/'), 'erés'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/iones$/'), 'ión'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/ces$/'), 'z'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/es$/'), ''));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/s$/'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/ú([sn])$/i'), '_PhpScoperabd03f0baf05\\u\\1es'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/ó([sn])$/i'), '_PhpScoperabd03f0baf05\\o\\1es'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/í([sn])$/i'), '_PhpScoperabd03f0baf05\\i\\1es'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/é([sn])$/i'), '_PhpScoperabd03f0baf05\\e\\1es'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/á([sn])$/i'), '_PhpScoperabd03f0baf05\\a\\1es'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/z$/i'), 'ces'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/([aeiou]s)$/i'), '\\1'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/([^aeéiou])$/i'), '\\1es'));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Pattern('/$/'), 's'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('el'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('los')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('papá'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('papás')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('mamá'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('mamás')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('sofá'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('sofás')));
        (yield new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('mes'), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Word('meses')));
    }
}
