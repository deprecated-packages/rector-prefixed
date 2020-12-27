<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Internal;

use PhpParser\Node\Expr\MethodCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
class UnionTypeGetInternalDynamicReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \PHPStan\Type\UnionType::class;
    }
    public function isMethodSupported(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'getInternal';
    }
    public function getTypeFromMethodCall(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($methodCall->args) < 2) {
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants())->getReturnType();
        }
        $getterClosureType = $scope->getType($methodCall->args[1]->value);
        return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($getterClosureType->getCallableParametersAcceptors($scope))->getReturnType();
    }
}
