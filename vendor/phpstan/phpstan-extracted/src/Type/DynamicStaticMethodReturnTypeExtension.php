<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PhpParser\Node\Expr\StaticCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
interface DynamicStaticMethodReturnTypeExtension
{
    public function getClass() : string;
    public function isStaticMethodSupported(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function getTypeFromStaticMethodCall(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\StaticCall $methodCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type;
}
