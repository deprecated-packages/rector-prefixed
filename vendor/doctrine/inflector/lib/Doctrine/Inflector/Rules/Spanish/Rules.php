<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Spanish;

use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Patterns;
use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Transformations(...\_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Spanish\Inflectible::getSingular()), new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Patterns(...\_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Spanish\Uninflected::getSingular()), (new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Spanish\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Transformations(...\_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Spanish\Inflectible::getPlural()), new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Patterns(...\_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Spanish\Uninflected::getPlural()), new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Spanish\Inflectible::getIrregular()));
    }
}
