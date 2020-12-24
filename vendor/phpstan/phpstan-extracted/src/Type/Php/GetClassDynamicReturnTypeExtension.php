<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StaticType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
class GetClassDynamicReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_class';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $args = $functionCall->args;
        if (\count($args) === 0) {
            if ($scope->isInClass()) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType($scope->getClassReflection()->getName(), \true);
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $argType = $scope->getType($args[0]->value);
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeTraverser::map($argType, static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType || $type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
                return $traverse($type);
            }
            if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\TemplateType && !$type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType($type);
            } elseif ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType();
            } elseif ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StaticType) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType($type->getStaticObjectType());
            } elseif ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\Generic\GenericClassStringType($type);
            } elseif ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType();
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false);
        });
    }
}
