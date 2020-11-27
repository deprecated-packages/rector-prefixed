<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Turkish;

use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Pattern;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Substitution;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Transformation;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return Transformation[]
     */
    public static function getSingular() : iterable
    {
        (yield new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Pattern('/l[ae]r$/i'), ''));
    }
    /**
     * @return Transformation[]
     */
    public static function getPlural() : iterable
    {
        (yield new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Pattern('/([eöiü][^aoıueöiü]{0,6})$/u'), '\\1ler'));
        (yield new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Transformation(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Pattern('/([aoıu][^aoıueöiü]{0,6})$/u'), '\\1lar'));
    }
    /**
     * @return Substitution[]
     */
    public static function getIrregular() : iterable
    {
        (yield new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Word('ben'), new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Word('biz')));
        (yield new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Word('sen'), new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Word('siz')));
        (yield new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Substitution(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Word('o'), new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Word('onlar')));
    }
}
