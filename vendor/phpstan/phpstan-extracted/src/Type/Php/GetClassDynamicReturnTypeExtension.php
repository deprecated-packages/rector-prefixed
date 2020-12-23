<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ClassStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StaticType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeTraverser;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
class GetClassDynamicReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_class';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $args = $functionCall->args;
        if (\count($args) === 0) {
            if ($scope->isInClass()) {
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType($scope->getClassReflection()->getName(), \true);
            }
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $argType = $scope->getType($args[0]->value);
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeTraverser::map($argType, static function (\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType || $type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType) {
                return $traverse($type);
            }
            if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\TemplateType && !$type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericClassStringType($type);
            } elseif ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ClassStringType();
            } elseif ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\StaticType) {
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericClassStringType($type->getStaticObjectType());
            } elseif ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Generic\GenericClassStringType($type);
            } elseif ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType) {
                return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ClassStringType();
            }
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false);
        });
    }
}
