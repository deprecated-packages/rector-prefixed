<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FunctionTypeSpecifyingExtension;
class DefineConstantTypeSpecifyingExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function setTypeSpecifier(\_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return $functionReflection->getName() === 'define' && $context->null() && \count($node->args) >= 2;
    }
    public function specifyTypes(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes
    {
        $constantName = $scope->getType($node->args[0]->value);
        if (!$constantName instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType || $constantName->getValue() === '') {
            return new \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes([], []);
        }
        return $this->typeSpecifier->create(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified($constantName->getValue())), $scope->getType($node->args[1]->value), \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext::createTruthy());
    }
}
