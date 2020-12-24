<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StaticType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeTraverser;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
class GetClassDynamicReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_class';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $args = $functionCall->args;
        if (\count($args) === 0) {
            if ($scope->isInClass()) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType($scope->getClassReflection()->getName(), \true);
            }
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $argType = $scope->getType($args[0]->value);
        return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeTraverser::map($argType, static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType || $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType) {
                return $traverse($type);
            }
            if ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\TemplateType && !$type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType($type);
            } elseif ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType();
            } elseif ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\StaticType) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType($type->getStaticObjectType());
            } elseif ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\Generic\GenericClassStringType($type);
            } elseif ($type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectWithoutClassType) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType();
            }
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
        });
    }
}
