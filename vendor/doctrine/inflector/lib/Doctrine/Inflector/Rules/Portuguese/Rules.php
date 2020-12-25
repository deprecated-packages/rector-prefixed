<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Portuguese;

use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Patterns;
use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformations(...\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Portuguese\Inflectible::getSingular()), new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Patterns(...\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Portuguese\Uninflected::getSingular()), (new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Portuguese\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Transformations(...\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Portuguese\Inflectible::getPlural()), new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Patterns(...\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Portuguese\Uninflected::getPlural()), new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Portuguese\Inflectible::getIrregular()));
    }
}
