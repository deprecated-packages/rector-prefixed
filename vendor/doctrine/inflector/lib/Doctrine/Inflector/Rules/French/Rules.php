<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\French;

use _PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Patterns;
use _PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\French\Inflectible::getSingular()), new \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\French\Uninflected::getSingular()), (new \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\French\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\French\Inflectible::getPlural()), new \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\French\Uninflected::getPlural()), new \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\French\Inflectible::getIrregular()));
    }
}
