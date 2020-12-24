<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Type\ClosureType;
use _PhpScopere8e811afab72\PHPStan\Type\ErrorType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
class ClosureFromCallableDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicStaticMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \Closure::class;
    }
    public function isStaticMethodSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'fromCallable';
    }
    public function getTypeFromStaticMethodCall(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall $methodCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $callableType = $scope->getType($methodCall->args[0]->value);
        if ($callableType->isCallable()->no()) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ErrorType();
        }
        $closureTypes = [];
        foreach ($callableType->getCallableParametersAcceptors($scope) as $variant) {
            $parameters = $variant->getParameters();
            $closureTypes[] = new \_PhpScopere8e811afab72\PHPStan\Type\ClosureType($parameters, $variant->getReturnType(), $variant->isVariadic());
        }
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$closureTypes);
    }
}
