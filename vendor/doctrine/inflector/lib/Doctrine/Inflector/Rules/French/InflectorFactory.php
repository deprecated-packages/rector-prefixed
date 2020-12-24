<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\French;

use _PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\French\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper2a4e7ab1ecbc\Doctrine\Inflector\Rules\French\Rules::getPluralRuleset();
    }
}
