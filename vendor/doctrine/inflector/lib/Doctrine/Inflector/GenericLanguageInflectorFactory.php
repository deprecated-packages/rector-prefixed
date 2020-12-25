<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2\Doctrine\Inflector;

use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset;
use function array_unshift;
abstract class GenericLanguageInflectorFactory implements \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\LanguageInflectorFactory
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
    public final function build() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Inflector
    {
        return new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Inflector(new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\CachedWordInflector(new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\RulesetInflector(...$this->singularRulesets)), new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\CachedWordInflector(new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\RulesetInflector(...$this->pluralRulesets)));
    }
    public final function withSingularRules(?\_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset $singularRules, bool $reset = \false) : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->singularRulesets = [];
        }
        if ($singularRules instanceof \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->singularRulesets, $singularRules);
        }
        return $this;
    }
    public final function withPluralRules(?\_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset $pluralRules, bool $reset = \false) : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->pluralRulesets = [];
        }
        if ($pluralRules instanceof \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->pluralRulesets, $pluralRules);
        }
        return $this;
    }
    protected abstract function getSingularRuleset() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset;
    protected abstract function getPluralRuleset() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Ruleset;
}
