<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
class RangeFunctionReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private const RANGE_LENGTH_THRESHOLD = 50;
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'range';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $startType = $scope->getType($functionCall->args[0]->value);
        $endType = $scope->getType($functionCall->args[1]->value);
        $stepType = \count($functionCall->args) >= 3 ? $scope->getType($functionCall->args[2]->value) : new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType(1);
        $constantReturnTypes = [];
        $startConstants = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantScalars($startType);
        foreach ($startConstants as $startConstant) {
            if (!$startConstant instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType && !$startConstant instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType && !$startConstant instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
                continue;
            }
            $endConstants = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantScalars($endType);
            foreach ($endConstants as $endConstant) {
                if (!$endConstant instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType && !$endConstant instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType && !$endConstant instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType) {
                    continue;
                }
                $stepConstants = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantScalars($stepType);
                foreach ($stepConstants as $stepConstant) {
                    if (!$stepConstant instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType && !$stepConstant instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantFloatType) {
                        continue;
                    }
                    $rangeValues = \range($startConstant->getValue(), $endConstant->getValue(), $stepConstant->getValue());
                    if (\count($rangeValues) > self::RANGE_LENGTH_THRESHOLD) {
                        return new \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union($startConstant->generalize(), $endConstant->generalize())), new \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType()]);
                    }
                    $arrayBuilder = \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
                    foreach ($rangeValues as $value) {
                        $arrayBuilder->setOffsetValueType(null, $scope->getTypeFromValue($value));
                    }
                    $constantReturnTypes[] = $arrayBuilder->getArray();
                }
            }
        }
        if (\count($constantReturnTypes) > 0) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$constantReturnTypes);
        }
        $argType = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union($startType, $endType);
        $isInteger = (new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType())->isSuperTypeOf($argType)->yes();
        $isStepInteger = (new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType())->isSuperTypeOf($stepType)->yes();
        if ($isInteger && $isStepInteger) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType());
        }
        $isFloat = (new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType())->isSuperTypeOf($argType)->yes();
        if ($isFloat) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType());
        }
        $numberType = new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType()]);
        $isNumber = $numberType->isSuperTypeOf($argType)->yes();
        if ($isNumber) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), $numberType);
        }
        $isString = (new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType())->isSuperTypeOf($argType)->yes();
        if ($isString) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType());
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType()]));
    }
}
