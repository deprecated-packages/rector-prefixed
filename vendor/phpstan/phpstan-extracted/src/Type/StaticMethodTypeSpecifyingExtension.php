<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
interface StaticMethodTypeSpecifyingExtension
{
    public function getClass() : string;
    public function isStaticMethodSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $staticMethodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : bool;
    public function specifyTypes(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $staticMethodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes;
}
