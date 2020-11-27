<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Doctrine\Inflector;

use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset;
use function array_unshift;
abstract class GenericLanguageInflectorFactory implements \_PhpScopera143bcca66cb\Doctrine\Inflector\LanguageInflectorFactory
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
    public final function build() : \_PhpScopera143bcca66cb\Doctrine\Inflector\Inflector
    {
        return new \_PhpScopera143bcca66cb\Doctrine\Inflector\Inflector(new \_PhpScopera143bcca66cb\Doctrine\Inflector\CachedWordInflector(new \_PhpScopera143bcca66cb\Doctrine\Inflector\RulesetInflector(...$this->singularRulesets)), new \_PhpScopera143bcca66cb\Doctrine\Inflector\CachedWordInflector(new \_PhpScopera143bcca66cb\Doctrine\Inflector\RulesetInflector(...$this->pluralRulesets)));
    }
    public final function withSingularRules(?\_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset $singularRules, bool $reset = \false) : \_PhpScopera143bcca66cb\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->singularRulesets = [];
        }
        if ($singularRules instanceof \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->singularRulesets, $singularRules);
        }
        return $this;
    }
    public final function withPluralRules(?\_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset $pluralRules, bool $reset = \false) : \_PhpScopera143bcca66cb\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->pluralRulesets = [];
        }
        if ($pluralRules instanceof \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->pluralRulesets, $pluralRules);
        }
        return $this;
    }
    protected abstract function getSingularRuleset() : \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset;
    protected abstract function getPluralRuleset() : \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Ruleset;
}
