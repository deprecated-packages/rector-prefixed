<?php

declare (strict_types=1);
namespace PHPStan\Type\PHPUnit;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Type;
use _PhpScoper50d83356d739\PHPUnit\Framework\MockObject\Builder\InvocationMocker;
class InvocationMockerDynamicReturnTypeExtension implements \PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return \_PhpScoper50d83356d739\PHPUnit\Framework\MockObject\Builder\InvocationMocker::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() !== 'getMatcher';
    }
    public function getTypeFromMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        return $scope->getType($methodCall->var);
    }
}
