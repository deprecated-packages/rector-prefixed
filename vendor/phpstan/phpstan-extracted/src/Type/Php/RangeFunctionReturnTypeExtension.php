<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\BenevolentUnionType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\IntersectionType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
class RangeFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private const RANGE_LENGTH_THRESHOLD = 50;
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'range';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $startType = $scope->getType($functionCall->args[0]->value);
        $endType = $scope->getType($functionCall->args[1]->value);
        $stepType = \count($functionCall->args) >= 3 ? $scope->getType($functionCall->args[2]->value) : new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(1);
        $constantReturnTypes = [];
        $startConstants = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantScalars($startType);
        foreach ($startConstants as $startConstant) {
            if (!$startConstant instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType && !$startConstant instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType && !$startConstant instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
                continue;
            }
            $endConstants = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantScalars($endType);
            foreach ($endConstants as $endConstant) {
                if (!$endConstant instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType && !$endConstant instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType && !$endConstant instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
                    continue;
                }
                $stepConstants = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantScalars($stepType);
                foreach ($stepConstants as $stepConstant) {
                    if (!$stepConstant instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType && !$stepConstant instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantFloatType) {
                        continue;
                    }
                    $rangeValues = \range($startConstant->getValue(), $endConstant->getValue(), $stepConstant->getValue());
                    if (\count($rangeValues) > self::RANGE_LENGTH_THRESHOLD) {
                        return new \_PhpScopere8e811afab72\PHPStan\Type\IntersectionType([new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union($startConstant->generalize(), $endConstant->generalize())), new \_PhpScopere8e811afab72\PHPStan\Type\Accessory\NonEmptyArrayType()]);
                    }
                    $arrayBuilder = \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
                    foreach ($rangeValues as $value) {
                        $arrayBuilder->setOffsetValueType(null, $scope->getTypeFromValue($value));
                    }
                    $constantReturnTypes[] = $arrayBuilder->getArray();
                }
            }
        }
        if (\count($constantReturnTypes) > 0) {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$constantReturnTypes);
        }
        $argType = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union($startType, $endType);
        $isInteger = (new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType())->isSuperTypeOf($argType)->yes();
        $isStepInteger = (new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType())->isSuperTypeOf($stepType)->yes();
        if ($isInteger && $isStepInteger) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType());
        }
        $isFloat = (new \_PhpScopere8e811afab72\PHPStan\Type\FloatType())->isSuperTypeOf($argType)->yes();
        if ($isFloat) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\FloatType());
        }
        $numberType = new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\FloatType()]);
        $isNumber = $numberType->isSuperTypeOf($argType)->yes();
        if ($isNumber) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), $numberType);
        }
        $isString = (new \_PhpScopere8e811afab72\PHPStan\Type\StringType())->isSuperTypeOf($argType)->yes();
        if ($isString) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType());
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\BenevolentUnionType([new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType(), new \_PhpScopere8e811afab72\PHPStan\Type\FloatType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType()]));
    }
}
