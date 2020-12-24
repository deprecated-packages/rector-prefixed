<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Portuguese;

use _PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Patterns;
use _PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Portuguese\Inflectible::getSingular()), new \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Portuguese\Uninflected::getSingular()), (new \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Portuguese\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Portuguese\Inflectible::getPlural()), new \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Portuguese\Uninflected::getPlural()), new \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Portuguese\Inflectible::getIrregular()));
    }
}
