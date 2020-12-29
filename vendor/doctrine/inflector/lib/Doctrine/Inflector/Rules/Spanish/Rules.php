<?php

declare (strict_types=1);
namespace RectorPrefix20201229\Doctrine\Inflector\Rules\Spanish;

use RectorPrefix20201229\Doctrine\Inflector\Rules\Patterns;
use RectorPrefix20201229\Doctrine\Inflector\Rules\Ruleset;
use RectorPrefix20201229\Doctrine\Inflector\Rules\Substitutions;
use RectorPrefix20201229\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \RectorPrefix20201229\Doctrine\Inflector\Rules\Ruleset
    {
        return new \RectorPrefix20201229\Doctrine\Inflector\Rules\Ruleset(new \RectorPrefix20201229\Doctrine\Inflector\Rules\Transformations(...\RectorPrefix20201229\Doctrine\Inflector\Rules\Spanish\Inflectible::getSingular()), new \RectorPrefix20201229\Doctrine\Inflector\Rules\Patterns(...\RectorPrefix20201229\Doctrine\Inflector\Rules\Spanish\Uninflected::getSingular()), (new \RectorPrefix20201229\Doctrine\Inflector\Rules\Substitutions(...\RectorPrefix20201229\Doctrine\Inflector\Rules\Spanish\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \RectorPrefix20201229\Doctrine\Inflector\Rules\Ruleset
    {
        return new \RectorPrefix20201229\Doctrine\Inflector\Rules\Ruleset(new \RectorPrefix20201229\Doctrine\Inflector\Rules\Transformations(...\RectorPrefix20201229\Doctrine\Inflector\Rules\Spanish\Inflectible::getPlural()), new \RectorPrefix20201229\Doctrine\Inflector\Rules\Patterns(...\RectorPrefix20201229\Doctrine\Inflector\Rules\Spanish\Uninflected::getPlural()), new \RectorPrefix20201229\Doctrine\Inflector\Rules\Substitutions(...\RectorPrefix20201229\Doctrine\Inflector\Rules\Spanish\Inflectible::getIrregular()));
    }
}
