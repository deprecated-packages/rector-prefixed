<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator;

use ReflectionClass;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
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
            if (!$documentedRule instanceof \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface) {
                throw new \_PhpScoperb75b35f52b74\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
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
        \usort($ruleDefinitions, function (\_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $firstRuleDefinition, \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition $secondRuleDefinition) : int {
            return $firstRuleDefinition->getRuleShortClass() <=> $secondRuleDefinition->getRuleShortClass();
        });
        return $ruleDefinitions;
    }
}
