<?php

declare (strict_types=1);
namespace Symplify\RuleDocGenerator;

use ReflectionClass;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\RuleClassWithFilePath;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210312\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class RuleDefinitionsResolver
{
    /**
     * @param RuleClassWithFilePath[] $ruleClassWithFilePaths
     * @return RuleDefinition[]
     */
    public function resolveFromClassNames(array $ruleClassWithFilePaths) : array
    {
        $ruleDefinitions = [];
        foreach ($ruleClassWithFilePaths as $ruleClassWithFilePath) {
            $reflectionClass = new \ReflectionClass($ruleClassWithFilePath->getClass());
            $documentedRule = $reflectionClass->newInstanceWithoutConstructor();
            if (!$documentedRule instanceof \Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface) {
                throw new \RectorPrefix20210312\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
            }
            $ruleDefinition = $documentedRule->getRuleDefinition();
            $ruleDefinition->setRuleClass($ruleClassWithFilePath->getClass());
            $ruleDefinition->setRuleFilePath($ruleClassWithFilePath->getPath());
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
