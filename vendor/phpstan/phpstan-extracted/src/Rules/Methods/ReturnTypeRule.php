<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Methods;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Rules\FunctionReturnTypeCheck;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\Return_>
 */
class ReturnTypeRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var \PHPStan\Rules\FunctionReturnTypeCheck */
    private $returnTypeCheck;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Rules\FunctionReturnTypeCheck $returnTypeCheck)
    {
        $this->returnTypeCheck = $returnTypeCheck;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if ($scope->getFunction() === null) {
            return [];
        }
        if ($scope->isInAnonymousFunction()) {
            return [];
        }
        $method = $scope->getFunction();
        if (!$method instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection) {
            return [];
        }
        $reflection = null;
        if ($method->getDeclaringClass()->getNativeReflection()->hasMethod($method->getName())) {
            $reflection = $method->getDeclaringClass()->getNativeReflection()->getMethod($method->getName());
        }
        return $this->returnTypeCheck->checkReturnType($scope, \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants())->getReturnType(), $node->expr, \sprintf('Method %s::%s() should return %%s but empty return statement found.', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('Method %s::%s() with return type void returns %%s but should not return anything.', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('Method %s::%s() should return %%s but returns %%s.', $method->getDeclaringClass()->getDisplayName(), $method->getName()), \sprintf('Method %s::%s() should never return but return statement found.', $method->getDeclaringClass()->getDisplayName(), $method->getName()), $reflection !== null && $reflection->isGenerator());
    }
}
