<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector;

use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset;
use function array_unshift;
abstract class GenericLanguageInflectorFactory implements \_PhpScoperbf340cb0be9d\Doctrine\Inflector\LanguageInflectorFactory
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
    public final function build() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Inflector
    {
        return new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Inflector(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\CachedWordInflector(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\RulesetInflector(...$this->singularRulesets)), new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\CachedWordInflector(new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\RulesetInflector(...$this->pluralRulesets)));
    }
    public final function withSingularRules(?\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset $singularRules, bool $reset = \false) : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->singularRulesets = [];
        }
        if ($singularRules instanceof \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->singularRulesets, $singularRules);
        }
        return $this;
    }
    public final function withPluralRules(?\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset $pluralRules, bool $reset = \false) : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->pluralRulesets = [];
        }
        if ($pluralRules instanceof \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->pluralRulesets, $pluralRules);
        }
        return $this;
    }
    protected abstract function getSingularRuleset() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset;
    protected abstract function getPluralRuleset() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Ruleset;
}
