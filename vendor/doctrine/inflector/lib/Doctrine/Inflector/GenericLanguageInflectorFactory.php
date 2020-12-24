<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Doctrine\Inflector;

use _PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset;
use function array_unshift;
abstract class GenericLanguageInflectorFactory implements \_PhpScoper0a6b37af0871\Doctrine\Inflector\LanguageInflectorFactory
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
    public final function build() : \_PhpScoper0a6b37af0871\Doctrine\Inflector\Inflector
    {
        return new \_PhpScoper0a6b37af0871\Doctrine\Inflector\Inflector(new \_PhpScoper0a6b37af0871\Doctrine\Inflector\CachedWordInflector(new \_PhpScoper0a6b37af0871\Doctrine\Inflector\RulesetInflector(...$this->singularRulesets)), new \_PhpScoper0a6b37af0871\Doctrine\Inflector\CachedWordInflector(new \_PhpScoper0a6b37af0871\Doctrine\Inflector\RulesetInflector(...$this->pluralRulesets)));
    }
    public final function withSingularRules(?\_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset $singularRules, bool $reset = \false) : \_PhpScoper0a6b37af0871\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->singularRulesets = [];
        }
        if ($singularRules instanceof \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->singularRulesets, $singularRules);
        }
        return $this;
    }
    public final function withPluralRules(?\_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset $pluralRules, bool $reset = \false) : \_PhpScoper0a6b37af0871\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->pluralRulesets = [];
        }
        if ($pluralRules instanceof \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->pluralRulesets, $pluralRules);
        }
        return $this;
    }
    protected abstract function getSingularRuleset() : \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset;
    protected abstract function getPluralRuleset() : \_PhpScoper0a6b37af0871\Doctrine\Inflector\Rules\Ruleset;
}
