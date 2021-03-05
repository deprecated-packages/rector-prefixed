<?php

declare (strict_types=1);
namespace RectorPrefix20210305\Doctrine\Inflector\Rules\French;

use RectorPrefix20210305\Doctrine\Inflector\GenericLanguageInflectorFactory;
use RectorPrefix20210305\Doctrine\Inflector\Rules\Ruleset;
final class InflectorFactory extends \RectorPrefix20210305\Doctrine\Inflector\GenericLanguageInflectorFactory
{
    protected function getSingularRuleset() : \RectorPrefix20210305\Doctrine\Inflector\Rules\Ruleset
    {
        return \RectorPrefix20210305\Doctrine\Inflector\Rules\French\Rules::getSingularRuleset();
    }
    protected function getPluralRuleset() : \RectorPrefix20210305\Doctrine\Inflector\Rules\Ruleset
    {
        return \RectorPrefix20210305\Doctrine\Inflector\Rules\French\Rules::getPluralRuleset();
    }
}
