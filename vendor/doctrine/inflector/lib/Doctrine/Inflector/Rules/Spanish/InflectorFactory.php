<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Spanish;

use RectorPrefix2020DecSat\Doctrine\Inflector\GenericLanguageInflectorFactory;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \RectorPrefix2020DecSat\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset
    {
        return \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Spanish\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset
    {
        return \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Spanish\Rules::getPluralRuleset();
    }
}
