<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Doctrine\Inflector;

use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset;
use function array_unshift;
abstract class GenericLanguageInflectorFactory implements \_PhpScoperb75b35f52b74\Doctrine\Inflector\LanguageInflectorFactory
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
    public final function build() : \_PhpScoperb75b35f52b74\Doctrine\Inflector\Inflector
    {
        return new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Inflector(new \_PhpScoperb75b35f52b74\Doctrine\Inflector\CachedWordInflector(new \_PhpScoperb75b35f52b74\Doctrine\Inflector\RulesetInflector(...$this->singularRulesets)), new \_PhpScoperb75b35f52b74\Doctrine\Inflector\CachedWordInflector(new \_PhpScoperb75b35f52b74\Doctrine\Inflector\RulesetInflector(...$this->pluralRulesets)));
    }
    public final function withSingularRules(?\_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset $singularRules, bool $reset = \false) : \_PhpScoperb75b35f52b74\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->singularRulesets = [];
        }
        if ($singularRules instanceof \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->singularRulesets, $singularRules);
        }
        return $this;
    }
    public final function withPluralRules(?\_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset $pluralRules, bool $reset = \false) : \_PhpScoperb75b35f52b74\Doctrine\Inflector\LanguageInflectorFactory
    {
        if ($reset) {
            $this->pluralRulesets = [];
        }
        if ($pluralRules instanceof \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset) {
            \array_unshift($this->pluralRulesets, $pluralRules);
        }
        return $this;
    }
    protected abstract function getSingularRuleset() : \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset;
    protected abstract function getPluralRuleset() : \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Ruleset;
}
