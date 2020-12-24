<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeTraverser;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
class GetClassDynamicReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_class';
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $args = $functionCall->args;
        if (\count($args) === 0) {
            if ($scope->isInClass()) {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType($scope->getClassReflection()->getName(), \true);
            }
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $argType = $scope->getType($args[0]->value);
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeTraverser::map($argType, static function (\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType || $type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType) {
                return $traverse($type);
            }
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\TemplateType && !$type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericClassStringType($type);
            } elseif ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType();
            } elseif ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StaticType) {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericClassStringType($type->getStaticObjectType());
            } elseif ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Generic\GenericClassStringType($type);
            } elseif ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectWithoutClassType) {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClassStringType();
            }
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false);
        });
    }
}
