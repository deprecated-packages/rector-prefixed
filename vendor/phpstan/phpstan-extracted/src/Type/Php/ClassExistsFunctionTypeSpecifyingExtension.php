<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension;
use _PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Type\ClassStringType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\FunctionTypeSpecifyingExtension;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
class ClassExistsFunctionTypeSpecifyingExtension implements \_PhpScopere8e811afab72\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \in_array($functionReflection->getName(), ['class_exists', 'interface_exists', 'trait_exists'], \true) && isset($node->args[0]) && $context->truthy();
    }
    public function specifyTypes(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes
    {
        $argType = $scope->getType($node->args[0]->value);
        $classStringType = new \_PhpScopere8e811afab72\PHPStan\Type\ClassStringType();
        if (\_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::intersect($argType, $classStringType) instanceof \_PhpScopere8e811afab72\PHPStan\Type\NeverType) {
            if ($argType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
                return $this->typeSpecifier->create(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('class_exists'), [new \_PhpScopere8e811afab72\PhpParser\Node\Arg(new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_(\ltrim($argType->getValue(), '\\')))]), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\true), $context);
            }
            return new \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes();
        }
        return $this->typeSpecifier->create($node->args[0]->value, $classStringType, $context);
    }
    public function setTypeSpecifier(\_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
