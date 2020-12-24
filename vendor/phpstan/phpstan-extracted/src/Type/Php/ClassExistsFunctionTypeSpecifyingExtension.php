<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator;
class ClassExistsFunctionTypeSpecifyingExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \in_array($functionReflection->getName(), ['class_exists', 'interface_exists', 'trait_exists'], \true) && isset($node->args[0]) && $context->truthy();
    }
    public function specifyTypes(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes
    {
        $argType = $scope->getType($node->args[0]->value);
        $classStringType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType();
        if (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::intersect($argType, $classStringType) instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NeverType) {
            if ($argType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType) {
                return $this->typeSpecifier->create(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified('class_exists'), [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_(\ltrim($argType->getValue(), '\\')))]), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\true), $context);
            }
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\SpecifiedTypes();
        }
        return $this->typeSpecifier->create($node->args[0]->value, $classStringType, $context);
    }
    public function setTypeSpecifier(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
