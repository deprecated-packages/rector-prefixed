<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Type\ClassStringType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\StaticType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeTraverser;
use _PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
class GetClassDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_class';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $args = $functionCall->args;
        if (\count($args) === 0) {
            if ($scope->isInClass()) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType($scope->getClassReflection()->getName(), \true);
            }
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $argType = $scope->getType($args[0]->value);
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeTraverser::map($argType, static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType || $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType) {
                return $traverse($type);
            }
            if ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType && !$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericClassStringType($type);
            } elseif ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\ClassStringType();
            } elseif ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\StaticType) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericClassStringType($type->getStaticObjectType());
            } elseif ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\Generic\GenericClassStringType($type);
            } elseif ($type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType) {
                return new \_PhpScopere8e811afab72\PHPStan\Type\ClassStringType();
            }
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false);
        });
    }
}
