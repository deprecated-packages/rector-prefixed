<?php

declare (strict_types=1);
namespace _PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Portuguese;

use _PhpScoper5edc98a7cce2\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper5edc98a7cce2\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Portuguese\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper5edc98a7cce2\Doctrine\Inflector\Rules\Portuguese\Rules::getPluralRuleset();
    }
}
