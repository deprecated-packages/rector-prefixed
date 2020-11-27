<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Portuguese;

use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Patterns;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Transformations(...\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Portuguese\Inflectible::getSingular()), new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Patterns(...\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Portuguese\Uninflected::getSingular()), (new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Portuguese\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Transformations(...\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Portuguese\Inflectible::getPlural()), new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Patterns(...\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Portuguese\Uninflected::getPlural()), new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Portuguese\Inflectible::getIrregular()));
    }
}
