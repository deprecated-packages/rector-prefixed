<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\NorwegianBokmal;

use _PhpScopera143bcca66cb\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScopera143bcca66cb\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\NorwegianBokmal\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\NorwegianBokmal\Rules::getPluralRuleset();
    }
}
