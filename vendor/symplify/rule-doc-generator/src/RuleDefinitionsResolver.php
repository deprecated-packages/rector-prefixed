<?php

declare (strict_types=1);
namespace RectorPrefix20201228\Symplify\RuleDocGenerator;

use ReflectionClass;
use RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20201228\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
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
            if (!$documentedRule instanceof \RectorPrefix20201228\Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface) {
                throw new \RectorPrefix20201228\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
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
        \usort($ruleDefinitions, function (\RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $firstRuleDefinition, \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $secondRuleDefinition) : int {
            return $firstRuleDefinition->getRuleShortClass() <=> $secondRuleDefinition->getRuleShortClass();
        });
        return $ruleDefinitions;
    }
}
