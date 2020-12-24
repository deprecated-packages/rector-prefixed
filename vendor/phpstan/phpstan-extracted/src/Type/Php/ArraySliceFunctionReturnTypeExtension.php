<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class ArraySliceFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_slice';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $arrayArg = $functionCall->args[0]->value ?? null;
        if ($arrayArg === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        }
        $valueType = $scope->getType($arrayArg);
        if (isset($functionCall->args[1])) {
            $offset = $scope->getType($functionCall->args[1]->value);
            if (!$offset instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
                $offset = new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(0);
            }
        } else {
            $offset = new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(0);
        }
        if (isset($functionCall->args[2])) {
            $limit = $scope->getType($functionCall->args[2]->value);
            if (!$limit instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType) {
                $limit = new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
            }
        } else {
            $limit = new \_PhpScopere8e811afab72\PHPStan\Type\NullType();
        }
        $constantArrays = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantArrays($valueType);
        if (\count($constantArrays) === 0) {
            $arrays = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getArrays($valueType);
            if (\count($arrays) !== 0) {
                return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$arrays);
            }
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        }
        if (isset($functionCall->args[3])) {
            $preserveKeys = $scope->getType($functionCall->args[3]->value);
            $preserveKeys = (new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($preserveKeys)->yes();
        } else {
            $preserveKeys = \false;
        }
        $arrayTypes = \array_map(static function (\_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType $constantArray) use($offset, $limit, $preserveKeys) : ConstantArrayType {
            return $constantArray->slice($offset->getValue(), $limit->getValue(), $preserveKeys);
        }, $constantArrays);
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$arrayTypes);
    }
}
