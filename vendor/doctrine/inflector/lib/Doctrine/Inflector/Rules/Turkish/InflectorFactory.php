<?php

declare (strict_types=1);
namespace _PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Turkish;

use _PhpScoper5b8c9e9ebd21\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Turkish\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper5b8c9e9ebd21\Doctrine\Inflector\Rules\Turkish\Rules::getPluralRuleset();
    }
}
