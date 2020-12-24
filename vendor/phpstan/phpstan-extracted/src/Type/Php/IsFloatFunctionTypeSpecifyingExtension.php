<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FunctionTypeSpecifyingExtension;
class IsFloatFunctionTypeSpecifyingExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \in_array(\strtolower($functionReflection->getName()), ['is_float', 'is_double', 'is_real'], \true) && isset($node->args[0]) && !$context->null();
    }
    public function specifyTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes
    {
        if ($context->null()) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
        }
        return $this->typeSpecifier->create($node->args[0]->value, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType(), $context);
    }
    public function setTypeSpecifier(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
