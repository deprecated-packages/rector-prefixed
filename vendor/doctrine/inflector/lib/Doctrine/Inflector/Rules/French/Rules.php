<?php

declare (strict_types=1);
namespace _PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\French;

use _PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Patterns;
use _PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\French\Inflectible::getSingular()), new \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\French\Uninflected::getSingular()), (new \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\French\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\French\Inflectible::getPlural()), new \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\French\Uninflected::getPlural()), new \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\French\Inflectible::getIrregular()));
    }
}
