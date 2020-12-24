<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Turkish;

use _PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Patterns;
use _PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Turkish\Inflectible::getSingular()), new \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Turkish\Uninflected::getSingular()), (new \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Turkish\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Transformations(...\_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Turkish\Inflectible::getPlural()), new \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Patterns(...\_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Turkish\Uninflected::getPlural()), new \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Turkish\Inflectible::getIrregular()));
    }
}
