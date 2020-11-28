<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\NorwegianBokmal;

use _PhpScoperabd03f0baf05\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoperabd03f0baf05\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\NorwegianBokmal\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\NorwegianBokmal\Rules::getPluralRuleset();
    }
}
