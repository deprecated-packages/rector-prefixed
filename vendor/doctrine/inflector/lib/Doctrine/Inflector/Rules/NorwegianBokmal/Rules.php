<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal;

use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Patterns;
use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset;
use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Substitutions;
use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Transformations;
final class Rules
{
    public static function getSingularRuleset() : \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Transformations(...\_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal\Inflectible::getSingular()), new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Patterns(...\_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal\Uninflected::getSingular()), (new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal\Inflectible::getIrregular()))->getFlippedSubstitutions());
    }
    public static function getPluralRuleset() : \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset
    {
        return new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset(new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Transformations(...\_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal\Inflectible::getPlural()), new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Patterns(...\_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal\Uninflected::getPlural()), new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Substitutions(...\_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal\Inflectible::getIrregular()));
    }
}
