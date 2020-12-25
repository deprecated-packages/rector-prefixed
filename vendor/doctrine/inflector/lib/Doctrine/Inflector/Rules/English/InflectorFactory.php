<?php

declare (strict_types=1);
namespace _PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\English;

use _PhpScoper8b9c402c5f32\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper8b9c402c5f32\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\English\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper8b9c402c5f32\Doctrine\Inflector\Rules\English\Rules::getPluralRuleset();
    }
}
