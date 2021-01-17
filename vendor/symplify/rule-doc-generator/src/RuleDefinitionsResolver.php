<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator;

use ReflectionClass;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210117\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
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
            if (!$documentedRule instanceof \Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface) {
                throw new \RectorPrefix20210117\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
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
        \usort($ruleDefinitions, function (\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $firstRuleDefinition, \Symplify\RuleDocGenerator\ValueObject\RuleDefinition $secondRuleDefinition) : int {
            return $firstRuleDefinition->getRuleShortClass() <=> $secondRuleDefinition->getRuleShortClass();
        });
        return $ruleDefinitions;
    }
}
