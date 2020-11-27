<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\NorwegianBokmal;

use _PhpScoper26e51eeacccf\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper26e51eeacccf\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\NorwegianBokmal\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper26e51eeacccf\Doctrine\Inflector\Rules\NorwegianBokmal\Rules::getPluralRuleset();
    }
}
