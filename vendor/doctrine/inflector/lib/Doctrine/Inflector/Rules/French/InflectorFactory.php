<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Doctrine\Inflector\Rules\French;

use _PhpScoper0a2ac50786fa\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper0a2ac50786fa\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper0a2ac50786fa\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper0a2ac50786fa\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper0a2ac50786fa\Doctrine\Inflector\Rules\French\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper0a2ac50786fa\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper0a2ac50786fa\Doctrine\Inflector\Rules\French\Rules::getPluralRuleset();
    }
}
