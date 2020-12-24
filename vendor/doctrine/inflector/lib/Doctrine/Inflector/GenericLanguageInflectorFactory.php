<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Doctrine\Inflector;

use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset;
use function array_unshift;
abstract class GenericLanguageInflectorFactory implements \_PhpScopere8e811afab72\Doctrine\Inflector\LanguageInflectorFactory
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
    public final function build() : \_PhpScopere8e811afab72\Doctrine\Inflector\Inflector
    {
        return new \_PhpScopere8e811afab72\Doctrine\Inflector\Inflector(new \_PhpScopere8e811afab72\Doctrine\Inflector\CachedWordInflector(new \_PhpScopere8e811afab72\Doctrine\Inflector\RulesetInflector(...$this->singularRulesets)), new \_PhpScopere8e811afab72\Doctrine\Inflector\CachedWordInflector(new \_PhpScopere8e811afab72\Doctrine\Inflector\RulesetInflector(...$this->pluralRulesets)));
    }
    public final function withSingularRules(?\_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset $singularRules, bool $reset = \false) : \_PhpScopere8e811afab72\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->singularRulesets = [];
        }
        if ($singularRules instanceof \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->singularRulesets, $singularRules);
        }
        return $this;
    }
    public final function withPluralRules(?\_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset $pluralRules, bool $reset = \false) : \_PhpScopere8e811afab72\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->pluralRulesets = [];
        }
        if ($pluralRules instanceof \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->pluralRulesets, $pluralRules);
        }
        return $this;
    }
    protected abstract function getSingularRuleset() : \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset;
    protected abstract function getPluralRuleset() : \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Ruleset;
}
