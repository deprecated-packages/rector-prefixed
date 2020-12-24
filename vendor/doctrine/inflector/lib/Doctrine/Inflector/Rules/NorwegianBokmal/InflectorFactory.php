<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Doctrine\Inflector\Rules\NorwegianBokmal;

use _PhpScopere8e811afab72\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScopere8e811afab72\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\NorwegianBokmal\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\NorwegianBokmal\Rules::getPluralRuleset();
    }
}
