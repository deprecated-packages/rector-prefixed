<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\PHPUnit\Assert;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MethodTypeSpecifyingExtension;
class AssertMethodTypeSpecifyingExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\MethodTypeSpecifyingExtension, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function setTypeSpecifier(\_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function getClass() : string
    {
        return '_PhpScoper0a2ac50786fa\\PHPUnit\\Framework\\TestCase';
    }
    public function isMethodSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\PHPUnit\Assert\AssertTypeSpecifyingExtensionHelper::isSupported($methodReflection->getName(), $node->args);
    }
    public function specifyTypes(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $node, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper0a2ac50786fa\PHPStan\Analyser\SpecifiedTypes
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\PHPUnit\Assert\AssertTypeSpecifyingExtensionHelper::specifyTypes($this->typeSpecifier, $scope, $functionReflection->getName(), $node->args);
    }
}
