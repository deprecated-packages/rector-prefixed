<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Internal;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Container;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
class ContainerDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Container::class;
    }
    public function isMethodSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return \in_array($methodReflection->getName(), ['getByType'], \true);
    }
    public function getTypeFromMethodCall(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (\count($methodCall->args) === 0) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        }
        $argType = $scope->getType($methodCall->args[0]->value);
        if (!$argType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        }
        $type = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($argType->getValue());
        if ($methodReflection->getName() === 'getByType' && \count($methodCall->args) >= 2) {
            $argType = $scope->getType($methodCall->args[1]->value);
            if ($argType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType && $argType->getValue()) {
                $type = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::addNull($type);
            }
        }
        return $type;
    }
}
