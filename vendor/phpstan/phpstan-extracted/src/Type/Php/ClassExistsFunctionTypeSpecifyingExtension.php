<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScoper0a6b37af0871\PHPStan\Type\NeverType;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
class ClassExistsFunctionTypeSpecifyingExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \in_array($functionReflection->getName(), ['class_exists', 'interface_exists', 'trait_exists'], \true) && isset($node->args[0]) && $context->truthy();
    }
    public function specifyTypes(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope, \_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes
    {
        $argType = $scope->getType($node->args[0]->value);
        $classStringType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType();
        if (\_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::intersect($argType, $classStringType) instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\NeverType) {
            if ($argType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
                return $this->typeSpecifier->create(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('class_exists'), [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg(new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_(\ltrim($argType->getValue(), '\\')))]), new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\true), $context);
            }
            return new \_PhpScoper0a6b37af0871\PHPStan\Analyser\SpecifiedTypes();
        }
        return $this->typeSpecifier->create($node->args[0]->value, $classStringType, $context);
    }
    public function setTypeSpecifier(\_PhpScoper0a6b37af0871\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
