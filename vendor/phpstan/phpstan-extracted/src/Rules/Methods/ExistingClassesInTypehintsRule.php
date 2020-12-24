<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Methods;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\InClassMethodNode;
use _PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use _PhpScopere8e811afab72\PHPStan\Rules\FunctionDefinitionCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PHPStan\Node\InClassMethodNode>
 */
class ExistingClassesInTypehintsRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionDefinitionCheck */
    private $check;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\FunctionDefinitionCheck $check)
    {
        $this->check = $check;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $methodReflection = $scope->getFunction();
        if (!$methodReflection instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        if (!$scope->isInClass()) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return $this->check->checkClassMethod($methodReflection, $node->getOriginalNode(), \sprintf('Parameter $%%s of method %s::%s() has invalid typehint type %%s.', $scope->getClassReflection()->getDisplayName(), $methodReflection->getName()), \sprintf('Return typehint of method %s::%s() has invalid type %%s.', $scope->getClassReflection()->getDisplayName(), $methodReflection->getName()), \sprintf('Method %s::%s() uses native union types but they\'re supported only on PHP 8.0 and later.', $scope->getClassReflection()->getDisplayName(), $methodReflection->getName()));
    }
}
