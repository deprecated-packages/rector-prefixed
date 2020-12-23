<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Internal;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MethodTypeSpecifyingExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
class ScopeIsInClassTypeSpecifyingExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\MethodTypeSpecifyingExtension, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var string */
    private $isInMethodName;
    /** @var string */
    private $removeNullMethodName;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function __construct(string $isInMethodName, string $removeNullMethodName, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->isInMethodName = $isInMethodName;
        $this->removeNullMethodName = $removeNullMethodName;
        $this->reflectionProvider = $reflectionProvider;
    }
    public function setTypeSpecifier(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function getClass() : string
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer::class;
    }
    public function isMethodSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $methodReflection->getName() === $this->isInMethodName && !$context->null();
    }
    public function specifyTypes(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes
    {
        $scopeClass = $this->reflectionProvider->getClass(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope::class);
        $methodVariants = $scopeClass->getMethod($this->removeNullMethodName, $scope)->getVariants();
        return $this->typeSpecifier->create(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($node->var, $this->removeNullMethodName), \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::removeNull(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodVariants)->getReturnType()), $context);
    }
}
