<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\Type;
class ArrayFillFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private const MAX_SIZE_USE_CONSTANT_ARRAY = 100;
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_fill';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 3) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $startIndexType = $scope->getType($functionCall->args[0]->value);
        $numberType = $scope->getType($functionCall->args[1]->value);
        $valueType = $scope->getType($functionCall->args[2]->value);
        if ($startIndexType instanceof \PHPStan\Type\Constant\ConstantIntegerType && $numberType instanceof \PHPStan\Type\Constant\ConstantIntegerType && $numberType->getValue() <= static::MAX_SIZE_USE_CONSTANT_ARRAY) {
            $arrayBuilder = \PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            $nextIndex = $startIndexType->getValue();
            for ($i = 0; $i < $numberType->getValue(); $i++) {
                $arrayBuilder->setOffsetValueType(new \PHPStan\Type\Constant\ConstantIntegerType($nextIndex), $valueType);
                if ($nextIndex < 0) {
                    $nextIndex = 0;
                } else {
                    $nextIndex++;
                }
            }
            return $arrayBuilder->getArray();
        }
        if ($numberType instanceof \PHPStan\Type\Constant\ConstantIntegerType && $numberType->getValue() > 0) {
            return new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), $valueType), new \PHPStan\Type\Accessory\NonEmptyArrayType()]);
        }
        return new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), $valueType);
    }
}
