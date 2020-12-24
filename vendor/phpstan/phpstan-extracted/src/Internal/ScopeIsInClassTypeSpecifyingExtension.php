<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Internal;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\MethodTypeSpecifyingExtension;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
class ScopeIsInClassTypeSpecifyingExtension implements \_PhpScopere8e811afab72\PHPStan\Type\MethodTypeSpecifyingExtension, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var string */
    private $isInMethodName;
    /** @var string */
    private $removeNullMethodName;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function __construct(string $isInMethodName, string $removeNullMethodName, \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->isInMethodName = $isInMethodName;
        $this->removeNullMethodName = $removeNullMethodName;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function setTypeSpecifier(\_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function getClass() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer::class;
    }
    public function isMethodSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $methodReflection->getName() === $this->isInMethodName && !$context->null();
    }
    public function specifyTypes(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes
    {
        $scopeClass = $this->reflectionProvider->getClass(\_PhpScopere8e811afab72\PHPStan\Analyser\Scope::class);
        $methodVariants = $scopeClass->getMethod($this->removeNullMethodName, $scope)->getVariants();
        return $this->typeSpecifier->create(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($node->var, $this->removeNullMethodName), \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::removeNull(\_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodVariants)->getReturnType()), $context);
    }
}
