<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Turkish;

use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Patterns;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformations(...\_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Turkish\Inflectible::getSingular()), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Patterns(...\_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Turkish\Uninflected::getSingular()), (new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Turkish\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Transformations(...\_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Turkish\Inflectible::getPlural()), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Patterns(...\_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Turkish\Uninflected::getPlural()), new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Turkish\Inflectible::getIrregular()));
    }
}
