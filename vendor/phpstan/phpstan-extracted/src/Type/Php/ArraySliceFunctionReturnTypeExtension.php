<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
class ArraySliceFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_slice';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $arrayArg = $functionCall->args[0]->value ?? null;
        if ($arrayArg === null) {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\MixedType());
        }
        $valueType = $scope->getType($arrayArg);
        if (isset($functionCall->args[1])) {
            $offset = $scope->getType($functionCall->args[1]->value);
            if (!$offset instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
                $offset = new \PHPStan\Type\Constant\ConstantIntegerType(0);
            }
        } else {
            $offset = new \PHPStan\Type\Constant\ConstantIntegerType(0);
        }
        if (isset($functionCall->args[2])) {
            $limit = $scope->getType($functionCall->args[2]->value);
            if (!$limit instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
                $limit = new \PHPStan\Type\NullType();
            }
        } else {
            $limit = new \PHPStan\Type\NullType();
        }
        $constantArrays = \PHPStan\Type\TypeUtils::getConstantArrays($valueType);
        if (\count($constantArrays) === 0) {
            $arrays = \PHPStan\Type\TypeUtils::getArrays($valueType);
            if (\count($arrays) !== 0) {
                return \PHPStan\Type\TypeCombinator::union(...$arrays);
            }
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        }
        if (isset($functionCall->args[3])) {
            $preserveKeys = $scope->getType($functionCall->args[3]->value);
            $preserveKeys = (new \PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($preserveKeys)->yes();
        } else {
            $preserveKeys = \false;
        }
        $arrayTypes = \array_map(static function (\PHPStan\Type\Constant\ConstantArrayType $constantArray) use($offset, $limit, $preserveKeys) : ConstantArrayType {
            return $constantArray->slice($offset->getValue(), $limit->getValue(), $preserveKeys);
        }, $constantArrays);
        return \PHPStan\Type\TypeCombinator::union(...$arrayTypes);
    }
}
