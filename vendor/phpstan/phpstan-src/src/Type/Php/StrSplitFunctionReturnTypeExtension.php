<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
final class StrSplitFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'str_split';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $defaultReturnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) < 1) {
            return $defaultReturnType;
        }
        $splitLength = 1;
        if (\count($functionCall->args) >= 2) {
            $splitLengthType = $scope->getType($functionCall->args[1]->value);
            if (!$splitLengthType instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
                return $defaultReturnType;
            }
            $splitLength = $splitLengthType->getValue();
            if ($splitLength < 1) {
                return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
            }
        }
        $stringType = $scope->getType($functionCall->args[0]->value);
        if (!$stringType instanceof \PHPStan\Type\Constant\ConstantStringType) {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType());
        }
        $stringValue = $stringType->getValue();
        $items = \str_split($stringValue, $splitLength);
        if (!\is_array($items)) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        return self::createConstantArrayFrom($items, $scope);
    }
    /**
     * @param string[] $constantArray
     * @param \PHPStan\Analyser\Scope $scope
     * @return \PHPStan\Type\Constant\ConstantArrayType
     */
    private static function createConstantArrayFrom(array $constantArray, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Constant\ConstantArrayType
    {
        $keyTypes = [];
        $valueTypes = [];
        $isList = \true;
        $i = 0;
        foreach ($constantArray as $key => $value) {
            $keyType = $scope->getTypeFromValue($key);
            if (!$keyType instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
                throw new \PHPStan\ShouldNotHappenException();
            }
            $keyTypes[] = $keyType;
            $valueTypes[] = $scope->getTypeFromValue($value);
            $isList = $isList && $key === $i;
            $i++;
        }
        return new \PHPStan\Type\Constant\ConstantArrayType($keyTypes, $valueTypes, $isList ? $i : 0);
    }
}
