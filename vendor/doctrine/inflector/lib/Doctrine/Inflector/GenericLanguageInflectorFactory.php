<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat\Doctrine\Inflector;

use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset;
use function array_unshift;
abstract class GenericLanguageInflectorFactory implements \RectorPrefix2020DecSat\Doctrine\Inflector\LanguageInflectorFactory
{
    /** @var Ruleset[] */
    private $singularRulesets = [];
    /** @var Ruleset[] */
    private $pluralRulesets = [];
    public final function __construct()
    {
        $this->singularRulesets[] = $this->getSingularRuleset();
        $this->pluralRulesets[] = $this->getPluralRuleset();
    }
    public final function build() : \RectorPrefix2020DecSat\Doctrine\Inflector\Inflector
    {
        return new \RectorPrefix2020DecSat\Doctrine\Inflector\Inflector(new \RectorPrefix2020DecSat\Doctrine\Inflector\CachedWordInflector(new \RectorPrefix2020DecSat\Doctrine\Inflector\RulesetInflector(...$this->singularRulesets)), new \RectorPrefix2020DecSat\Doctrine\Inflector\CachedWordInflector(new \RectorPrefix2020DecSat\Doctrine\Inflector\RulesetInflector(...$this->pluralRulesets)));
    }
    public final function withSingularRules(?\RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset $singularRules, bool $reset = \false) : \RectorPrefix2020DecSat\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->singularRulesets = [];
        }
        if ($singularRules instanceof \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->singularRulesets, $singularRules);
        }
        return $this;
    }
    public final function withPluralRules(?\RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset $pluralRules, bool $reset = \false) : \RectorPrefix2020DecSat\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->pluralRulesets = [];
        }
        if ($pluralRules instanceof \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->pluralRulesets, $pluralRules);
        }
        return $this;
    }
    protected abstract function getSingularRuleset() : \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset;
    protected abstract function getPluralRuleset() : \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Ruleset;
}
