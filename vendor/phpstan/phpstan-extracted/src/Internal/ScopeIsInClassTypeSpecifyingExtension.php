<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Internal;

use PhpParser\Node\Expr\MethodCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension;
use RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext;
use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\MethodTypeSpecifyingExtension;
use PHPStan\Type\TypeCombinator;
class ScopeIsInClassTypeSpecifyingExtension implements \PHPStan\Type\MethodTypeSpecifyingExtension, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var string */
    private $isInMethodName;
    /** @var string */
    private $removeNullMethodName;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function __construct(string $isInMethodName, string $removeNullMethodName, \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->isInMethodName = $isInMethodName;
        $this->removeNullMethodName = $removeNullMethodName;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function setTypeSpecifier(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function getClass() : string
    {
        return \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer::class;
    }
    public function isMethodSupported(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $node, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $methodReflection->getName() === $this->isInMethodName && !$context->null();
    }
    public function specifyTypes(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $methodReflection, \PhpParser\Node\Expr\MethodCall $node, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifierContext $context) : \RectorPrefix20201227\PHPStan\Analyser\SpecifiedTypes
    {
        $scopeClass = $this->reflectionProvider->getClass(\RectorPrefix20201227\PHPStan\Analyser\Scope::class);
        $methodVariants = $scopeClass->getMethod($this->removeNullMethodName, $scope)->getVariants();
        return $this->typeSpecifier->create(new \PhpParser\Node\Expr\MethodCall($node->var, $this->removeNullMethodName), \PHPStan\Type\TypeCombinator::removeNull(\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodVariants)->getReturnType()), $context);
    }
}
