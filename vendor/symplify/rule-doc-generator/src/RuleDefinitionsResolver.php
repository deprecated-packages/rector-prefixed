<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator;

use ReflectionClass;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class RuleDefinitionsResolver
{
    /**
     * @param string[] $classNames
     * @return RuleDefinition[]
     */
    public function resolveFromClassNames(array $classNames) : array
    {
        $ruleDefinitions = [];
        foreach ($classNames as $className) {
            $reflectionClass = new \ReflectionClass($className);
            $documentedRule = $reflectionClass->newInstanceWithoutConstructor();
            if (!$documentedRule instanceof \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface) {
                throw new \_PhpScoper0a2ac50786fa\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
            }
            $ruleDefinition = $documentedRule->getRuleDefinition();
            $ruleDefinition->setRuleClass($className);
            $ruleDefinitions[] = $ruleDefinition;
        }
        return $this->sortByClassName($ruleDefinitions);
    }
    /**
     * @param RuleDefinition[] $ruleDefinitions
     * @return RuleDefinition[]
     */
    private function sortByClassName(array $ruleDefinitions) : array
    {
        \usort($ruleDefinitions, function (\_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $firstRuleDefinition, \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $secondRuleDefinition) : int {
            return $firstRuleDefinition->getRuleShortClass() <=> $secondRuleDefinition->getRuleShortClass();
        });
        return $ruleDefinitions;
    }
}
