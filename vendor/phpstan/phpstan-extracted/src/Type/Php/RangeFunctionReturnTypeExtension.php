<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BenevolentUnionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
class RangeFunctionReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private const RANGE_LENGTH_THRESHOLD = 50;
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'range';
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $startType = $scope->getType($functionCall->args[0]->value);
        $endType = $scope->getType($functionCall->args[1]->value);
        $stepType = \count($functionCall->args) >= 3 ? $scope->getType($functionCall->args[2]->value) : new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType(1);
        $constantReturnTypes = [];
        $startConstants = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::getConstantScalars($startType);
        foreach ($startConstants as $startConstant) {
            if (!$startConstant instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType && !$startConstant instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType && !$startConstant instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType) {
                continue;
            }
            $endConstants = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::getConstantScalars($endType);
            foreach ($endConstants as $endConstant) {
                if (!$endConstant instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType && !$endConstant instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType && !$endConstant instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType) {
                    continue;
                }
                $stepConstants = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::getConstantScalars($stepType);
                foreach ($stepConstants as $stepConstant) {
                    if (!$stepConstant instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType && !$stepConstant instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantFloatType) {
                        continue;
                    }
                    $rangeValues = \range($startConstant->getValue(), $endConstant->getValue(), $stepConstant->getValue());
                    if (\count($rangeValues) > self::RANGE_LENGTH_THRESHOLD) {
                        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union($startConstant->generalize(), $endConstant->generalize())), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Accessory\NonEmptyArrayType()]);
                    }
                    $arrayBuilder = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
                    foreach ($rangeValues as $value) {
                        $arrayBuilder->setOffsetValueType(null, $scope->getTypeFromValue($value));
                    }
                    $constantReturnTypes[] = $arrayBuilder->getArray();
                }
            }
        }
        if (\count($constantReturnTypes) > 0) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union(...$constantReturnTypes);
        }
        $argType = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union($startType, $endType);
        $isInteger = (new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType())->isSuperTypeOf($argType)->yes();
        $isStepInteger = (new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType())->isSuperTypeOf($stepType)->yes();
        if ($isInteger && $isStepInteger) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType());
        }
        $isFloat = (new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType())->isSuperTypeOf($argType)->yes();
        if ($isFloat) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType());
        }
        $numberType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType()]);
        $isNumber = $numberType->isSuperTypeOf($argType)->yes();
        if ($isNumber) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), $numberType);
        }
        $isString = (new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType())->isSuperTypeOf($argType)->yes();
        if ($isString) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType());
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BenevolentUnionType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType()]));
    }
}
