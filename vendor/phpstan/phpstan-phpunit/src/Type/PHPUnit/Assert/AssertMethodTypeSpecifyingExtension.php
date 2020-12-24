<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\PHPUnit\Assert;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Type\MethodTypeSpecifyingExtension;
class AssertMethodTypeSpecifyingExtension implements \_PhpScopere8e811afab72\PHPStan\Type\MethodTypeSpecifyingExtension, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function setTypeSpecifier(\_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function getClass() : string
    {
        return '_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase';
    }
    public function isMethodSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\PHPUnit\Assert\AssertTypeSpecifyingExtensionHelper::isSupported($methodReflection->getName(), $node->args);
    }
    public function specifyTypes(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes
    {
        return \_PhpScopere8e811afab72\PHPStan\Type\PHPUnit\Assert\AssertTypeSpecifyingExtensionHelper::specifyTypes($this->typeSpecifier, $scope, $functionReflection->getName(), $node->args);
    }
}
