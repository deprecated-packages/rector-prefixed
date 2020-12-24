<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
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
use _PhpScopere8e811afab72\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NeverType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\TypeTraverser;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
class IsSubclassOfFunctionTypeSpecifyingExtension implements \_PhpScopere8e811afab72\PHPStan\Type\FunctionTypeSpecifyingExtension, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierAwareExtension
{
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : bool
    {
        return \strtolower($functionReflection->getName()) === 'is_subclass_of' && \count($node->args) >= 2 && !$context->null();
    }
    public function specifyTypes(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifierContext $context) : \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes
    {
        $objectType = $scope->getType($node->args[0]->value);
        $classType = $scope->getType($node->args[1]->value);
        $allowStringType = isset($node->args[2]) ? $scope->getType($node->args[2]->value) : new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\true);
        $allowString = !$allowStringType->equals(new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false));
        if (!$classType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            if ($context->truthy()) {
                if ($allowString) {
                    $type = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType(), new \_PhpScopere8e811afab72\PHPStan\Type\ClassStringType());
                } else {
                    $type = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType();
                }
                return $this->typeSpecifier->create($node->args[0]->value, $type, $context);
            }
            return new \_PhpScopere8e811afab72\PHPStan\Analyser\SpecifiedTypes();
        }
        $type = \_PhpScopere8e811afab72\PHPStan\Type\TypeTraverser::map($objectType, static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type, callable $traverse) use($classType, $allowString) : Type {
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
                return $traverse($type);
            }
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
                return $traverse($type);
            }
            if ($allowString) {
                if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\StringType) {
                    return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericClassStringType(new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($classType->getValue()));
                }
            }
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($classType->getValue());
            }
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
                $objectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($classType->getValue());
                if ($allowString) {
                    return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(new \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericClassStringType($objectType), $objectType);
                }
                return $objectType;
            }
            return new \_PhpScopere8e811afab72\PHPStan\Type\NeverType();
        });
        return $this->typeSpecifier->create($node->args[0]->value, $type, $context);
    }
    public function setTypeSpecifier(\_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier $typeSpecifier) : void
    {
        $this->typeSpecifier = $typeSpecifier;
    }
}
