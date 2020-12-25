<?php

declare (strict_types=1);
namespace _PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Spanish;

use _PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Patterns;
use _PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Spanish\Inflectible::getSingular()), new \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Spanish\Uninflected::getSingular()), (new \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Spanish\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Spanish\Inflectible::getPlural()), new \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Spanish\Uninflected::getPlural()), new \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Spanish\Inflectible::getIrregular()));
    }
}
