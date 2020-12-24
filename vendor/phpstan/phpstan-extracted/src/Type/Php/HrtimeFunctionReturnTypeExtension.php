<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class HrtimeFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'hrtime';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(0), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(1)], [new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType()], 2);
        $numberType = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::toBenevolentUnion(\_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\FloatType()));
        if (\count($functionCall->args) < 1) {
            return $arrayType;
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $isTrueType = (new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($argType);
        $isFalseType = (new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false))->isSuperTypeOf($argType);
        $compareTypes = $isTrueType->compareTo($isFalseType);
        if ($compareTypes === $isTrueType) {
            return $numberType;
        }
        if ($compareTypes === $isFalseType) {
            return $arrayType;
        }
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union($arrayType, $numberType);
    }
}
