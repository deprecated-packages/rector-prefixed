<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Turkish;

use _PhpScoperfce0de0de1ce\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoperfce0de0de1ce\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Turkish\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Turkish\Rules::getPluralRuleset();
    }
}
