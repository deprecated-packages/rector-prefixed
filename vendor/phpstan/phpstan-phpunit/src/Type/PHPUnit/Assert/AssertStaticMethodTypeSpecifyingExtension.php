<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\PHPUnit\Assert;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticMethodTypeSpecifyingExtension;
class AssertStaticMethodTypeSpecifyingExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\StaticMethodTypeSpecifyingExtension, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function setTypeSpecifier(\_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function getClass() : string
    {
        return '_PhpScoperb75b35f52b74\\PHPUnit\\Framework\\Assert';
    }
    public function isStaticMethodSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\PHPUnit\Assert\AssertTypeSpecifyingExtensionHelper::isSupported($methodReflection->getName(), $node->args);
    }
    public function specifyTypes(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $node, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoperb75b35f52b74\PHPStan\Analyser\SpecifiedTypes
    {
        return \_PhpScoperb75b35f52b74\PHPStan\Type\PHPUnit\Assert\AssertTypeSpecifyingExtensionHelper::specifyTypes($this->typeSpecifier, $scope, $functionReflection->getName(), $node->args);
    }
}
