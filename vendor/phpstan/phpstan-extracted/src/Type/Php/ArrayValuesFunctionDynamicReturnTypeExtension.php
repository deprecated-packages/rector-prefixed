<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
class ArrayValuesFunctionDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_values';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $arrayArg = $functionCall->args[0]->value ?? null;
        if ($arrayArg !== null) {
            $valueType = $scope->getType($arrayArg);
            if ($valueType->isArray()->yes()) {
                if ($valueType instanceof \PHPStan\Type\Constant\ConstantArrayType) {
                    return $valueType->getValuesArray();
                }
                return \PHPStan\Type\TypeCombinator::intersect(new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), $valueType->getIterableValueType()), ...\PHPStan\Type\TypeUtils::getAccessoryTypes($valueType));
            }
        }
        return new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\MixedType());
    }
}
