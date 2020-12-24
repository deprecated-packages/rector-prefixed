<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\BenevolentUnionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\FloatType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
class RangeFunctionReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private const RANGE_LENGTH_THRESHOLD = 50;
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'range';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $startType = $scope->getType($functionCall->args[0]->value);
        $endType = $scope->getType($functionCall->args[1]->value);
        $stepType = \count($functionCall->args) >= 3 ? $scope->getType($functionCall->args[2]->value) : new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType(1);
        $constantReturnTypes = [];
        $startConstants = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantScalars($startType);
        foreach ($startConstants as $startConstant) {
            if (!$startConstant instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType && !$startConstant instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType && !$startConstant instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
                continue;
            }
            $endConstants = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantScalars($endType);
            foreach ($endConstants as $endConstant) {
                if (!$endConstant instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType && !$endConstant instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType && !$endConstant instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType) {
                    continue;
                }
                $stepConstants = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantScalars($stepType);
                foreach ($stepConstants as $stepConstant) {
                    if (!$stepConstant instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType && !$stepConstant instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantFloatType) {
                        continue;
                    }
                    $rangeValues = \range($startConstant->getValue(), $endConstant->getValue(), $stepConstant->getValue());
                    if (\count($rangeValues) > self::RANGE_LENGTH_THRESHOLD) {
                        return new \_PhpScoper0a6b37af0871\PHPStan\Type\IntersectionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union($startConstant->generalize(), $endConstant->generalize())), new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\NonEmptyArrayType()]);
                    }
                    $arrayBuilder = \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
                    foreach ($rangeValues as $value) {
                        $arrayBuilder->setOffsetValueType(null, $scope->getTypeFromValue($value));
                    }
                    $constantReturnTypes[] = $arrayBuilder->getArray();
                }
            }
        }
        if (\count($constantReturnTypes) > 0) {
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$constantReturnTypes);
        }
        $argType = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union($startType, $endType);
        $isInteger = (new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType())->isSuperTypeOf($argType)->yes();
        $isStepInteger = (new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType())->isSuperTypeOf($stepType)->yes();
        if ($isInteger && $isStepInteger) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType());
        }
        $isFloat = (new \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType())->isSuperTypeOf($argType)->yes();
        if ($isFloat) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType());
        }
        $numberType = new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType()]);
        $isNumber = $numberType->isSuperTypeOf($argType)->yes();
        if ($isNumber) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), $numberType);
        }
        $isString = (new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType())->isSuperTypeOf($argType)->yes();
        if ($isString) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType());
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\BenevolentUnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\FloatType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType()]));
    }
}
