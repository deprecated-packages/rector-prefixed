<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Turkish;

use _PhpScoperbf340cb0be9d\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoperbf340cb0be9d\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Turkish\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Turkish\Rules::getPluralRuleset();
    }
}
