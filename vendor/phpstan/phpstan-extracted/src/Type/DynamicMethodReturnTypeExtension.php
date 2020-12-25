<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
interface DynamicMethodReturnTypeExtension
{
    public function getClass() : string;
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function getTypeFromMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type;
}
