<?php

declare (strict_types=1);
namespace RectorPrefix20210422\Doctrine\Inflector\Rules\Turkish;

use RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern;
use RectorPrefix20210422\Doctrine\Inflector\Rules\Substitution;
use RectorPrefix20210422\Doctrine\Inflector\Rules\Transformation;
use RectorPrefix20210422\Doctrine\Inflector\Rules\Word;
class Inflectible
{
    /**
     * @return mixed[]
     */
    public static function getSingular()
    {
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern('/l[ae]r$/i'), ''));
    }
    /**
     * @return mixed[]
     */
    public static function getPlural()
    {
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern('/([eöiü][^aoıueöiü]{0,6})$/u'), '\\1ler'));
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern('/([aoıu][^aoıueöiü]{0,6})$/u'), '\\1lar'));
    }
    /**
     * @return mixed[]
     */
    public static function getIrregular()
    {
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix20210422\Doctrine\Inflector\Rules\Word('ben'), new \RectorPrefix20210422\Doctrine\Inflector\Rules\Word('biz')));
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix20210422\Doctrine\Inflector\Rules\Word('sen'), new \RectorPrefix20210422\Doctrine\Inflector\Rules\Word('siz')));
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix20210422\Doctrine\Inflector\Rules\Word('o'), new \RectorPrefix20210422\Doctrine\Inflector\Rules\Word('onlar')));
    }
}
