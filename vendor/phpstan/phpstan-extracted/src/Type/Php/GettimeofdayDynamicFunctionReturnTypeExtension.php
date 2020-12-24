<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Type\BenevolentUnionType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
class GettimeofdayDynamicFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'gettimeofday';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType('sec'), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType('usec'), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType('minuteswest'), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType('dsttime')], [new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType()]);
        $floatType = new \_PhpScopere8e811afab72\PHPStan\Type\FloatType();
        if (!isset($functionCall->args[0])) {
            return $arrayType;
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $isTrueType = (new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($argType);
        $isFalseType = (new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false))->isSuperTypeOf($argType);
        $compareTypes = $isTrueType->compareTo($isFalseType);
        if ($compareTypes === $isTrueType) {
            return $floatType;
        }
        if ($compareTypes === $isFalseType) {
            return $arrayType;
        }
        if ($argType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\BenevolentUnionType([$arrayType, $floatType]);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([$arrayType, $floatType]);
    }
}
