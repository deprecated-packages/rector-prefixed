<?php

declare (strict_types=1);
namespace _PhpScoper267b3276efc2\Doctrine\Inflector\Rules\English;

use _PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Patterns;
use _PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\English\Inflectible::getSingular()), new \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\English\Uninflected::getSingular()), (new \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\English\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\English\Inflectible::getPlural()), new \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\English\Uninflected::getPlural()), new \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\English\Inflectible::getIrregular()));
    }
}
