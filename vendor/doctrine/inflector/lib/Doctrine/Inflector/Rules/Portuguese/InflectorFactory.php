<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Portuguese;

use _PhpScoper006a73f0e455\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoper006a73f0e455\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Portuguese\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoper006a73f0e455\Doctrine\Inflector\Rules\Portuguese\Rules::getPluralRuleset();
    }
}
