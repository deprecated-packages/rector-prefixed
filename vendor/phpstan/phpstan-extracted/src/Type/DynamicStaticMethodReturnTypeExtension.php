<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
interface DynamicStaticMethodReturnTypeExtension
{
    public function getClass() : string;
    public function isStaticMethodSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection) : bool;
    public function getTypeFromStaticMethodCall(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall $methodCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type;
}
