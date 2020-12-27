<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PhpParser\Node\Expr\StaticCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
interface DynamicStaticMethodReturnTypeExtension
{
    public function getClass() : string;
    public function isStaticMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function getTypeFromStaticMethodCall(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\StaticCall $methodCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type;
}
