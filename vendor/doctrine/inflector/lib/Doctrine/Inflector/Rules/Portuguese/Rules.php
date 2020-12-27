<?php

declare (strict_types=1);
namespace RectorPrefix20201227\Doctrine\Inflector\Rules\Portuguese;

use RectorPrefix20201227\Doctrine\Inflector\Rules\Patterns;
use RectorPrefix20201227\Doctrine\Inflector\Rules\Ruleset;
use RectorPrefix20201227\Doctrine\Inflector\Rules\Substitutions;
use RectorPrefix20201227\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \RectorPrefix20201227\Doctrine\Inflector\Rules\Ruleset
    {
        return new \RectorPrefix20201227\Doctrine\Inflector\Rules\Ruleset(new \RectorPrefix20201227\Doctrine\Inflector\Rules\Transformations(...\RectorPrefix20201227\Doctrine\Inflector\Rules\Portuguese\Inflectible::getSingular()), new \RectorPrefix20201227\Doctrine\Inflector\Rules\Patterns(...\RectorPrefix20201227\Doctrine\Inflector\Rules\Portuguese\Uninflected::getSingular()), (new \RectorPrefix20201227\Doctrine\Inflector\Rules\Substitutions(...\RectorPrefix20201227\Doctrine\Inflector\Rules\Portuguese\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \RectorPrefix20201227\Doctrine\Inflector\Rules\Ruleset
    {
        return new \RectorPrefix20201227\Doctrine\Inflector\Rules\Ruleset(new \RectorPrefix20201227\Doctrine\Inflector\Rules\Transformations(...\RectorPrefix20201227\Doctrine\Inflector\Rules\Portuguese\Inflectible::getPlural()), new \RectorPrefix20201227\Doctrine\Inflector\Rules\Patterns(...\RectorPrefix20201227\Doctrine\Inflector\Rules\Portuguese\Uninflected::getPlural()), new \RectorPrefix20201227\Doctrine\Inflector\Rules\Substitutions(...\RectorPrefix20201227\Doctrine\Inflector\Rules\Portuguese\Inflectible::getIrregular()));
    }
}
