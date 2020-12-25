<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BenevolentUnionType;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\Constant\ConstantFloatType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
use PHPStan\Type\UnionType;
class RangeFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private const RANGE_LENGTH_THRESHOLD = 50;
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'range';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $startType = $scope->getType($functionCall->args[0]->value);
        $endType = $scope->getType($functionCall->args[1]->value);
        $stepType = \count($functionCall->args) >= 3 ? $scope->getType($functionCall->args[2]->value) : new \PHPStan\Type\Constant\ConstantIntegerType(1);
        $constantReturnTypes = [];
        $startConstants = \PHPStan\Type\TypeUtils::getConstantScalars($startType);
        foreach ($startConstants as $startConstant) {
            if (!$startConstant instanceof \PHPStan\Type\Constant\ConstantIntegerType && !$startConstant instanceof \PHPStan\Type\Constant\ConstantFloatType && !$startConstant instanceof \PHPStan\Type\Constant\ConstantStringType) {
                continue;
            }
            $endConstants = \PHPStan\Type\TypeUtils::getConstantScalars($endType);
            foreach ($endConstants as $endConstant) {
                if (!$endConstant instanceof \PHPStan\Type\Constant\ConstantIntegerType && !$endConstant instanceof \PHPStan\Type\Constant\ConstantFloatType && !$endConstant instanceof \PHPStan\Type\Constant\ConstantStringType) {
                    continue;
                }
                $stepConstants = \PHPStan\Type\TypeUtils::getConstantScalars($stepType);
                foreach ($stepConstants as $stepConstant) {
                    if (!$stepConstant instanceof \PHPStan\Type\Constant\ConstantIntegerType && !$stepConstant instanceof \PHPStan\Type\Constant\ConstantFloatType) {
                        continue;
                    }
                    $rangeValues = \range($startConstant->getValue(), $endConstant->getValue(), $stepConstant->getValue());
                    if (\count($rangeValues) > self::RANGE_LENGTH_THRESHOLD) {
                        return new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), \PHPStan\Type\TypeCombinator::union($startConstant->generalize(), $endConstant->generalize())), new \PHPStan\Type\Accessory\NonEmptyArrayType()]);
                    }
                    $arrayBuilder = \PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
                    foreach ($rangeValues as $value) {
                        $arrayBuilder->setOffsetValueType(null, $scope->getTypeFromValue($value));
                    }
                    $constantReturnTypes[] = $arrayBuilder->getArray();
                }
            }
        }
        if (\count($constantReturnTypes) > 0) {
            return \PHPStan\Type\TypeCombinator::union(...$constantReturnTypes);
        }
        $argType = \PHPStan\Type\TypeCombinator::union($startType, $endType);
        $isInteger = (new \PHPStan\Type\IntegerType())->isSuperTypeOf($argType)->yes();
        $isStepInteger = (new \PHPStan\Type\IntegerType())->isSuperTypeOf($stepType)->yes();
        if ($isInteger && $isStepInteger) {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType());
        }
        $isFloat = (new \PHPStan\Type\FloatType())->isSuperTypeOf($argType)->yes();
        if ($isFloat) {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType());
        }
        $numberType = new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType()]);
        $isNumber = $numberType->isSuperTypeOf($argType)->yes();
        if ($isNumber) {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), $numberType);
        }
        $isString = (new \PHPStan\Type\StringType())->isSuperTypeOf($argType)->yes();
        if ($isString) {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType());
        }
        return new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\BenevolentUnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType(), new \PHPStan\Type\StringType()]));
    }
}
