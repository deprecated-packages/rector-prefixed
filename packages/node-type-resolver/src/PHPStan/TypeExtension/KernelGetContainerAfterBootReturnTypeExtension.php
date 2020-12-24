<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\TypeExtension;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Symfony\Component\HttpKernel\Kernel;
final class KernelGetContainerAfterBootReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScopere8e811afab72\Symfony\Component\HttpKernel\Kernel::class;
    }
    public function isMethodSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getContainer';
    }
    public function getTypeFromMethodCall(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $returnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        if (!$this->isCalledAfterBoot($scope, $methodCall)) {
            return $returnType;
        }
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            foreach ($returnType->getTypes() as $singleType) {
                if ($singleType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
                    return $singleType;
                }
            }
        }
        return $returnType;
    }
    private function isCalledAfterBoot(\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $kernelBootMethodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($methodCall->var, 'boot');
        return !$scope->getType($kernelBootMethodCall) instanceof \_PhpScopere8e811afab72\PHPStan\Type\ErrorType;
    }
}
