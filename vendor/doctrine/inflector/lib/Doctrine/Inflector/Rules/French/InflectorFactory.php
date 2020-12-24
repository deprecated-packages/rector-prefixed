<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\French;

use _PhpScoper0a6b37af0871\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper0a6b37af0871\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\French\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\French\Rules::getPluralRuleset();
    }
}
