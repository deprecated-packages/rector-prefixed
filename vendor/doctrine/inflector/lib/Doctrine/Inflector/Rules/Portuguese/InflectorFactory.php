<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Portuguese;

use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\GenericLanguageInflectorFactory;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Portuguese\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset
    {
        return \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Portuguese\Rules::getPluralRuleset();
    }
}
