<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\Generic\TemplateType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StaticType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeTraverser;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
class GetClassDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_class';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $args = $functionCall->args;
        if (\count($args) === 0) {
            if ($scope->isInClass()) {
                return new \PHPStan\Type\Constant\ConstantStringType($scope->getClassReflection()->getName(), \true);
            }
            return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $argType = $scope->getType($args[0]->value);
        return \PHPStan\Type\TypeTraverser::map($argType, static function (\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \PHPStan\Type\UnionType || $type instanceof \PHPStan\Type\IntersectionType) {
                return $traverse($type);
            }
            if ($type instanceof \PHPStan\Type\Generic\TemplateType && !$type instanceof \PHPStan\Type\TypeWithClassName) {
                return new \PHPStan\Type\Generic\GenericClassStringType($type);
            } elseif ($type instanceof \PHPStan\Type\MixedType) {
                return new \PHPStan\Type\ClassStringType();
            } elseif ($type instanceof \PHPStan\Type\StaticType) {
                return new \PHPStan\Type\Generic\GenericClassStringType($type->getStaticObjectType());
            } elseif ($type instanceof \PHPStan\Type\TypeWithClassName) {
                return new \PHPStan\Type\Generic\GenericClassStringType($type);
            } elseif ($type instanceof \PHPStan\Type\ObjectWithoutClassType) {
                return new \PHPStan\Type\ClassStringType();
            }
            return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
        });
    }
}
