<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat\Doctrine\Inflector\Rules\English;

use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Patterns;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitutions;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset
    {
        return new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformations(...\RectorPrefix2020DecSat\Doctrine\Inflector\Rules\English\Inflectible::getSingular()), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Patterns(...\RectorPrefix2020DecSat\Doctrine\Inflector\Rules\English\Uninflected::getSingular()), (new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitutions(...\RectorPrefix2020DecSat\Doctrine\Inflector\Rules\English\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset
    {
        return new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset(new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Transformations(...\RectorPrefix2020DecSat\Doctrine\Inflector\Rules\English\Inflectible::getPlural()), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Patterns(...\RectorPrefix2020DecSat\Doctrine\Inflector\Rules\English\Uninflected::getPlural()), new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Substitutions(...\RectorPrefix2020DecSat\Doctrine\Inflector\Rules\English\Inflectible::getIrregular()));
    }
}
