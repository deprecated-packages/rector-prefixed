<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Doctrine\Inflector;

use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset;
use function array_unshift;
abstract class GenericLanguageInflectorFactory implements \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\LanguageInflectorFactory
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
    public final function build() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Inflector
    {
        return new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Inflector(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\CachedWordInflector(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\RulesetInflector(...$this->singularRulesets)), new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\CachedWordInflector(new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\RulesetInflector(...$this->pluralRulesets)));
    }
    public final function withSingularRules(?\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset $singularRules, bool $reset = \false) : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->singularRulesets = [];
        }
        if ($singularRules instanceof \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->singularRulesets, $singularRules);
        }
        return $this;
    }
    public final function withPluralRules(?\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset $pluralRules, bool $reset = \false) : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->pluralRulesets = [];
        }
        if ($pluralRules instanceof \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->pluralRulesets, $pluralRules);
        }
        return $this;
    }
    protected abstract function getSingularRuleset() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset;
    protected abstract function getPluralRuleset() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Ruleset;
}
