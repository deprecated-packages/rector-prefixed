<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce\Doctrine\Inflector;

use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Ruleset;
use function array_unshift;
abstract class GenericLanguageInflectorFactory implements \_PhpScoperfce0de0de1ce\Doctrine\Inflector\LanguageInflectorFactory
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
    public final function build() : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Inflector
    {
        return new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Inflector(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\CachedWordInflector(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\RulesetInflector(...$this->singularRulesets)), new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\CachedWordInflector(new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\RulesetInflector(...$this->pluralRulesets)));
    }
    public final function withSingularRules(?\_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Ruleset $singularRules, bool $reset = \false) : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->singularRulesets = [];
        }
        if ($singularRules instanceof \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->singularRulesets, $singularRules);
        }
        return $this;
    }
    public final function withPluralRules(?\_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Ruleset $pluralRules, bool $reset = \false) : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->pluralRulesets = [];
        }
        if ($pluralRules instanceof \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->pluralRulesets, $pluralRules);
        }
        return $this;
    }
    protected abstract function getSingularRuleset() : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Ruleset;
    protected abstract function getPluralRuleset() : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Ruleset;
}
