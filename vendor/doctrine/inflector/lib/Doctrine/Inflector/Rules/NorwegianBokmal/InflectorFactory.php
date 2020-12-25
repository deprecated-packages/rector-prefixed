<?php

declare (strict_types=1);
namespace _PhpScoper267b3276efc2\Doctrine\Inflector\Rules\NorwegianBokmal;

use _PhpScoper267b3276efc2\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper267b3276efc2\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\NorwegianBokmal\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper267b3276efc2\Doctrine\Inflector\Rules\NorwegianBokmal\Rules::getPluralRuleset();
    }
}
