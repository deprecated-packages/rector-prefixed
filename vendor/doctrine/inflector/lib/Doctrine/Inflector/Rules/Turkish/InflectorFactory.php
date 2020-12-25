<?php

declare (strict_types=1);
namespace _PhpScoper567b66d83109\Doctrine\Inflector\Rules\Turkish;

use _PhpScoper567b66d83109\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper567b66d83109\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper567b66d83109\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Turkish\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper567b66d83109\Doctrine\Inflector\Rules\Turkish\Rules::getPluralRuleset();
    }
}
