<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class ArrayFillFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private const MAX_SIZE_USE_CONSTANT_ARRAY = 100;
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_fill';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 3) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $startIndexType = $scope->getType($functionCall->args[0]->value);
        $numberType = $scope->getType($functionCall->args[1]->value);
        $valueType = $scope->getType($functionCall->args[2]->value);
        if ($startIndexType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType && $numberType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType && $numberType->getValue() <= static::MAX_SIZE_USE_CONSTANT_ARRAY) {
            $arrayBuilder = \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            $nextIndex = $startIndexType->getValue();
            for ($i = 0; $i < $numberType->getValue(); $i++) {
                $arrayBuilder->setOffsetValueType(new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType($nextIndex), $valueType);
                if ($nextIndex < 0) {
                    $nextIndex = 0;
                } else {
                    $nextIndex++;
                }
            }
            return $arrayBuilder->getArray();
        }
        if ($numberType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType && $numberType->getValue() > 0) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType([new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), $valueType), new \_PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType()]);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), $valueType);
    }
}
