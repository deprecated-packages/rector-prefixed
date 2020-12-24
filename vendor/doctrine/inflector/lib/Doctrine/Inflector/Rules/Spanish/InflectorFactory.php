<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Spanish;

use _PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Spanish\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Spanish\Rules::getPluralRuleset();
    }
}
