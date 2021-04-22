<?php

declare (strict_types=1);
namespace RectorPrefix20210422\Doctrine\Inflector\Rules\NorwegianBokmal;

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
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern('/re$/i'), 'r'));
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern('/er$/i'), ''));
    }
    /**
     * @return mixed[]
     */
    public static function getPlural()
    {
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern('/e$/i'), 'er'));
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern('/r$/i'), 're'));
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Transformation(new \RectorPrefix20210422\Doctrine\Inflector\Rules\Pattern('/$/'), 'er'));
    }
    /**
     * @return mixed[]
     */
    public static function getIrregular()
    {
        (yield new \RectorPrefix20210422\Doctrine\Inflector\Rules\Substitution(new \RectorPrefix20210422\Doctrine\Inflector\Rules\Word('konto'), new \RectorPrefix20210422\Doctrine\Inflector\Rules\Word('konti')));
    }
}
