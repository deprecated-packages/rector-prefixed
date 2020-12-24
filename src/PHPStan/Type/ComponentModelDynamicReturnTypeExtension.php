<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PHPStan\Type;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
/**
 * @copied from https://github.com/phpstan/phpstan-nette/blob/master/src/Type/Nette/ComponentModelDynamicReturnTypeExtension.php
 */
final class ComponentModelDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return '_PhpScopere8e811afab72\\Nette\\ComponentModel\\Container';
    }
    public function isMethodSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getComponent';
    }
    public function getTypeFromMethodCall(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $calledOnType = $scope->getType($methodCall->var);
        $mixedType = new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        $args = $methodCall->args;
        if (\count($args) !== 1) {
            return $mixedType;
        }
        $argType = $scope->getType($args[0]->value);
        if (!$argType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            return $mixedType;
        }
        $methodName = \sprintf('createComponent%s', \ucfirst($argType->getValue()));
        if (!$calledOnType->hasMethod($methodName)->yes()) {
            return $mixedType;
        }
        $method = $calledOnType->getMethod($methodName, $scope);
        return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants())->getReturnType();
    }
}
