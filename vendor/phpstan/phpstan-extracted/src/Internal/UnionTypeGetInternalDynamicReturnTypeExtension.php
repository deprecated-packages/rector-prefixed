<?php

declare (strict_types=1);
namespace PHPStan\Internal;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
class UnionTypeGetInternalDynamicReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \PHPStan\Type\UnionType::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getInternal';
    }
    public function getTypeFromMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($methodCall->args) < 2) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        }
        $getterClosureType = $scope->getType($methodCall->args[1]->value);
        return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($getterClosureType->getCallableParametersAcceptors($scope))->getReturnType();
    }
}
