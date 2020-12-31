<?php

declare (strict_types=1);
namespace RectorPrefix20201231\Doctrine\Inflector;

use RectorPrefix20201231\Doctrine\Inflector\Rules\Ruleset;
use function array_unshift;
abstract class GenericLanguageInflectorFactory implements \RectorPrefix20201231\Doctrine\Inflector\LanguageInflectorFactory
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
    public final function build() : \RectorPrefix20201231\Doctrine\Inflector\Inflector
    {
        return new \RectorPrefix20201231\Doctrine\Inflector\Inflector(new \RectorPrefix20201231\Doctrine\Inflector\CachedWordInflector(new \RectorPrefix20201231\Doctrine\Inflector\RulesetInflector(...$this->singularRulesets)), new \RectorPrefix20201231\Doctrine\Inflector\CachedWordInflector(new \RectorPrefix20201231\Doctrine\Inflector\RulesetInflector(...$this->pluralRulesets)));
    }
    public final function withSingularRules(?\RectorPrefix20201231\Doctrine\Inflector\Rules\Ruleset $singularRules, bool $reset = \false) : \RectorPrefix20201231\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->singularRulesets = [];
        }
        if ($singularRules instanceof \RectorPrefix20201231\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->singularRulesets, $singularRules);
        }
        return $this;
    }
    public final function withPluralRules(?\RectorPrefix20201231\Doctrine\Inflector\Rules\Ruleset $pluralRules, bool $reset = \false) : \RectorPrefix20201231\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->pluralRulesets = [];
        }
        if ($pluralRules instanceof \RectorPrefix20201231\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->pluralRulesets, $pluralRules);
        }
        return $this;
    }
    protected abstract function getSingularRuleset() : \RectorPrefix20201231\Doctrine\Inflector\Rules\Ruleset;
    protected abstract function getPluralRuleset() : \RectorPrefix20201231\Doctrine\Inflector\Rules\Ruleset;
}
