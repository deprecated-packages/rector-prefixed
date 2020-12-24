<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Internal;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Type\MethodTypeSpecifyingExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
class ScopeIsInClassTypeSpecifyingExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\MethodTypeSpecifyingExtension, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var string */
    private $isInMethodName;
    /** @var string */
    private $removeNullMethodName;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function __construct(string $isInMethodName, string $removeNullMethodName, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->isInMethodName = $isInMethodName;
        $this->removeNullMethodName = $removeNullMethodName;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function setTypeSpecifier(\_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function getClass() : string
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer::class;
    }
    public function isMethodSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $methodReflection->getName() === $this->isInMethodName && !$context->null();
    }
    public function specifyTypes(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes
    {
        $scopeClass = $this->reflectionProvider->getClass(\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope::class);
        $methodVariants = $scopeClass->getMethod($this->removeNullMethodName, $scope)->getVariants();
        return $this->typeSpecifier->create(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($node->var, $this->removeNullMethodName), \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::removeNull(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodVariants)->getReturnType()), $context);
    }
}
