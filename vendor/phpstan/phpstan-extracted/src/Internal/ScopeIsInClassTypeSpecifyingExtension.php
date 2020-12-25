<?php

declare (strict_types=1);
namespace PHPStan\Internal;

use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Analyser\SpecifiedTypes;
use PHPStan\Analyser\TypeSpecifier;
use PHPStan\Analyser\TypeSpecifierAwareExtension;
use PHPStan\Analyser\TypeSpecifierContext;
use PHPStan\Reflection\ClassMemberAccessAnswerer;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\MethodTypeSpecifyingExtension;
use PHPStan\Type\TypeCombinator;
class ScopeIsInClassTypeSpecifyingExtension implements \PHPStan\Type\MethodTypeSpecifyingExtension, \PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var string */
    private $isInMethodName;
    /** @var string */
    private $removeNullMethodName;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function __construct(string $isInMethodName, string $removeNullMethodName, \PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->isInMethodName = $isInMethodName;
        $this->removeNullMethodName = $removeNullMethodName;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function setTypeSpecifier(\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function getClass() : string
    {
        return \PHPStan\Reflection\ClassMemberAccessAnswerer::class;
    }
    public function isMethodSupported(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $node, \PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $methodReflection->getName() === $this->isInMethodName && !$context->null();
    }
    public function specifyTypes(\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $node, \PHPStan\Analyser\Scope $scope, \PHPStan\Analyser\TypeSpecifierContext $context) : \PHPStan\Analyser\SpecifiedTypes
    {
        $scopeClass = $this->reflectionProvider->getClass(\PHPStan\Analyser\Scope::class);
        $methodVariants = $scopeClass->getMethod($this->removeNullMethodName, $scope)->getVariants();
        return $this->typeSpecifier->create(new \PhpParser\Node\Expr\MethodCall($node->var, $this->removeNullMethodName), \PHPStan\Type\TypeCombinator::removeNull(\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodVariants)->getReturnType()), $context);
    }
}
