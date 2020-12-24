<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal;

use _PhpScoperb75b35f52b74\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoperb75b35f52b74\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal\Rules::getPluralRuleset();
    }
}
