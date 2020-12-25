<?php

declare (strict_types=1);
namespace _PhpScoper17db12703726\Doctrine\Inflector\Rules\French;

use _PhpScoper17db12703726\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper17db12703726\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper17db12703726\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper17db12703726\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper17db12703726\Doctrine\Inflector\Rules\French\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper17db12703726\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper17db12703726\Doctrine\Inflector\Rules\French\Rules::getPluralRuleset();
    }
}
