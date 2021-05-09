<?php

declare (strict_types=1);
namespace RectorPrefix20210509\Doctrine\Inflector;

use RectorPrefix20210509\Doctrine\Inflector\Rules\Ruleset;
use function array_unshift;
abstract class GenericLanguageInflectorFactory implements \RectorPrefix20210509\Doctrine\Inflector\LanguageInflectorFactory
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
    public final function build() : \RectorPrefix20210509\Doctrine\Inflector\Inflector
    {
        return new \RectorPrefix20210509\Doctrine\Inflector\Inflector(new \RectorPrefix20210509\Doctrine\Inflector\CachedWordInflector(new \RectorPrefix20210509\Doctrine\Inflector\RulesetInflector(...$this->singularRulesets)), new \RectorPrefix20210509\Doctrine\Inflector\CachedWordInflector(new \RectorPrefix20210509\Doctrine\Inflector\RulesetInflector(...$this->pluralRulesets)));
    }
    public final function withSingularRules(?\RectorPrefix20210509\Doctrine\Inflector\Rules\Ruleset $singularRules, bool $reset = \false) : self
    {
        if ($reset) {
            $this->singularRulesets = [];
        }
        if ($singularRules instanceof \RectorPrefix20210509\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->singularRulesets, $singularRules);
        }
        return $this;
    }
    public final function withPluralRules(?\RectorPrefix20210509\Doctrine\Inflector\Rules\Ruleset $pluralRules, bool $reset = \false) : self
    {
        if ($reset) {
            $this->pluralRulesets = [];
        }
        if ($pluralRules instanceof \RectorPrefix20210509\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->pluralRulesets, $pluralRules);
        }
        return $this;
    }
    protected abstract function getSingularRuleset() : \RectorPrefix20210509\Doctrine\Inflector\Rules\Ruleset;
    protected abstract function getPluralRuleset() : \RectorPrefix20210509\Doctrine\Inflector\Rules\Ruleset;
}
