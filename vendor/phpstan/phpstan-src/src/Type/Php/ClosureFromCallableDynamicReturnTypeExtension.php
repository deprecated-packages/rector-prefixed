<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\ClosureType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
class ClosureFromCallableDynamicReturnTypeExtension implements \PHPStan\Type\DynamicStaticMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \Closure::class;
    }
    public function isStaticMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'fromCallable';
    }
    public function getTypeFromStaticMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\StaticCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $callableType = $scope->getType($methodCall->args[0]->value);
        if ($callableType->isCallable()->no()) {
            return new \PHPStan\Type\ErrorType();
        }
        $closureTypes = [];
        foreach ($callableType->getCallableParametersAcceptors($scope) as $variant) {
            $parameters = $variant->getParameters();
            $closureTypes[] = new \PHPStan\Type\ClosureType($parameters, $variant->getReturnType(), $variant->isVariadic());
        }
        return \PHPStan\Type\TypeCombinator::union(...$closureTypes);
    }
}
