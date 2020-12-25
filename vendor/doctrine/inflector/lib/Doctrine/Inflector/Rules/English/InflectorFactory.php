<?php

declare (strict_types=1);
namespace _PhpScoper50d83356d739\Doctrine\Inflector\Rules\English;

use _PhpScoper50d83356d739\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper50d83356d739\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper50d83356d739\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\English\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper50d83356d739\Doctrine\Inflector\Rules\English\Rules::getPluralRuleset();
    }
}
