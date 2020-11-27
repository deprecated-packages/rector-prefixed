<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\English;

use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Patterns;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Transformations(...\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\English\Inflectible::getSingular()), new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Patterns(...\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\English\Uninflected::getSingular()), (new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\English\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Transformations(...\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\English\Inflectible::getPlural()), new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Patterns(...\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\English\Uninflected::getPlural()), new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\English\Inflectible::getIrregular()));
    }
}
