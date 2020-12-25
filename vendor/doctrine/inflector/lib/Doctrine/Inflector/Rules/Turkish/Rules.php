<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109\Doctrine\Inflector\Rules\Turkish;

use _PhpScoper567b66d83109\Doctrine\Inflector\Rules\Patterns;
use _PhpScoper567b66d83109\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoper567b66d83109\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoper567b66d83109\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Turkish\Inflectible::getSingular()), new \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Turkish\Uninflected::getSingular()), (new \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Turkish\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Turkish\Inflectible::getPlural()), new \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Turkish\Uninflected::getPlural()), new \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Turkish\Inflectible::getIrregular()));
    }
}
