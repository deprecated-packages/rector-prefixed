<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\French;

use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\French\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\French\Rules::getPluralRuleset();
    }
}
