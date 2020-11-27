<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\English;

use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Patterns;
use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset;
use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitutions;
use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformations(...\_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\English\Inflectible::getSingular()), new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Patterns(...\_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\English\Uninflected::getSingular()), (new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitutions(...\_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\English\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset(new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Transformations(...\_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\English\Inflectible::getPlural()), new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Patterns(...\_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\English\Uninflected::getPlural()), new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Substitutions(...\_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\English\Inflectible::getIrregular()));
    }
}
