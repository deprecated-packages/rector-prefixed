<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PhpParser\Node\Expr\MethodCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
interface DynamicMethodReturnTypeExtension
{
    public function getClass() : string;
    public function isMethodSupported(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function getTypeFromMethodCall(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $methodCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type;
}
