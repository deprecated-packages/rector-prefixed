<?php

declare(strict_types=1);

namespace Doctrine\Inflector;

use Doctrine\Inflector\Rules\Ruleset;
use function array_unshift;

abstract class GenericLanguageInflectorFactory implements LanguageInflectorFactory
{
    /** @var Ruleset[] */
    private $singularRulesets = [];

    /** @var Ruleset[] */
    private $pluralRulesets = [];

    final public function __construct()
    {
        $this->singularRulesets[] = $this->getSingularRuleset();
        $this->pluralRulesets[]   = $this->getPluralRuleset();
    }

    final public function build() : Inflector
    {
        return new Inflector(
            new CachedWordInflector(new RulesetInflector(
                ...$this->singularRulesets
            )),
            new CachedWordInflector(new RulesetInflector(
                ...$this->pluralRulesets
            ))
        );
    }

    /**
     * @param \Doctrine\Inflector\Rules\Ruleset|null $singularRules
     */
    final public function withSingularRules($singularRules, bool $reset = false) : self
    {
        if ($reset) {
            $this->singularRulesets = [];
        }

        if ($singularRules instanceof Ruleset) {
            array_unshift($this->singularRulesets, $singularRules);
        }

        return $this;
    }

    /**
     * @param \Doctrine\Inflector\Rules\Ruleset|null $pluralRules
     */
    final public function withPluralRules($pluralRules, bool $reset = false) : self
    {
        if ($reset) {
            $this->pluralRulesets = [];
        }

        if ($pluralRules instanceof Ruleset) {
            array_unshift($this->pluralRulesets, $pluralRules);
        }

        return $this;
    }

    abstract protected function getSingularRuleset() : Ruleset;

    abstract protected function getPluralRuleset() : Ruleset;
}
