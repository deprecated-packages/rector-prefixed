<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator;

use ReflectionClass;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\RuleClassWithFilePath;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210309\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class RuleDefinitionsResolver
{
    /**
     * @param RuleClassWithFilePath[] $classNames
     * @return RuleDefinition[]
     */
    public function resolveFromClassNames(array $classNames) : array
    {
        $ruleDefinitions = [];
        foreach ($classNames as $rule) {
            $reflectionClass = new \ReflectionClass($rule->getClass());
            $documentedRule = $reflectionClass->newInstanceWithoutConstructor();
            if (!$documentedRule instanceof \Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface) {
                throw new \RectorPrefix20210309\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
            }
            $ruleDefinition = $documentedRule->getRuleDefinition();
            $ruleDefinition->setRuleClass($rule->getClass());
            $ruleDefinition->setRuleFilePath($rule->getPath());
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
