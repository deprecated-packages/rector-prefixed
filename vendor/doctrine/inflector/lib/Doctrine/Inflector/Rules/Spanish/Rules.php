<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Spanish;

use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Patterns;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Substitutions;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformations(...\_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Spanish\Inflectible::getSingular()), new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Patterns(...\_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Spanish\Uninflected::getSingular()), (new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Substitutions(...\_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Spanish\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset(new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Transformations(...\_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Spanish\Inflectible::getPlural()), new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Patterns(...\_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Spanish\Uninflected::getPlural()), new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Substitutions(...\_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Spanish\Inflectible::getIrregular()));
    }
}
