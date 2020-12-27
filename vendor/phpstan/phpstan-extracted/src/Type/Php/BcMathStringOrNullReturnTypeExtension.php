<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\UnaryMinus;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\Accessory\AccessoryNumericStringType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\ConstantScalarType;
use PHPStan\Type\IntegerRangeType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\NullType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\UnionType;
use function in_array;
use function is_numeric;
class BcMathStringOrNullReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['bcdiv', 'bcmod', 'bcpowmod', 'bcsqrt'], \true);
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if ($functionReflection->getName() === 'bcsqrt') {
            return $this->getTypeForBcSqrt($functionCall, $scope);
        }
        if ($functionReflection->getName() === 'bcpowmod') {
            return $this->getTypeForBcPowMod($functionCall, $scope);
        }
        $stringAndNumericStringType = \PHPStan\Type\TypeCombinator::intersect(new \PHPStan\Type\StringType(), new \PHPStan\Type\Accessory\AccessoryNumericStringType());
        $defaultReturnType = new \PHPStan\Type\UnionType([$stringAndNumericStringType, new \PHPStan\Type\NullType()]);
        if (isset($functionCall->args[1]) === \false) {
            return $stringAndNumericStringType;
        }
        $secondArgument = $scope->getType($functionCall->args[1]->value);
        $secondArgumentIsNumeric = $secondArgument instanceof \PHPStan\Type\ConstantScalarType && \is_numeric($secondArgument->getValue()) || $secondArgument instanceof \PHPStan\Type\IntegerType;
        if ($secondArgument instanceof \PHPStan\Type\ConstantScalarType && ($this->isZero($secondArgument->getValue()) || !$secondArgumentIsNumeric)) {
            return new \PHPStan\Type\NullType();
        }
        if (isset($functionCall->args[2]) === \false) {
            if ($secondArgument instanceof \PHPStan\Type\ConstantScalarType || $secondArgumentIsNumeric) {
                return $stringAndNumericStringType;
            }
            return $defaultReturnType;
        }
        $thirdArgument = $scope->getType($functionCall->args[2]->value);
        $thirdArgumentIsNumeric = $thirdArgument instanceof \PHPStan\Type\ConstantScalarType && \is_numeric($thirdArgument->getValue()) || $thirdArgument instanceof \PHPStan\Type\IntegerType;
        if ($thirdArgument instanceof \PHPStan\Type\ConstantScalarType && !\is_numeric($thirdArgument->getValue())) {
            return new \PHPStan\Type\NullType();
        }
        if (($secondArgument instanceof \PHPStan\Type\ConstantScalarType || $secondArgumentIsNumeric) && $thirdArgumentIsNumeric) {
            return $stringAndNumericStringType;
        }
        return $defaultReturnType;
    }
    /**
     * bcsqrt
     * https://www.php.net/manual/en/function.bcsqrt.php
     * > Returns the square root as a string, or NULL if operand is negative.
     *
     * @param FuncCall $functionCall
     * @param Scope $scope
     * @return Type
     */
    private function getTypeForBcSqrt(\PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $stringAndNumericStringType = \PHPStan\Type\TypeCombinator::intersect(new \PHPStan\Type\StringType(), new \PHPStan\Type\Accessory\AccessoryNumericStringType());
        $defaultReturnType = new \PHPStan\Type\UnionType([$stringAndNumericStringType, new \PHPStan\Type\NullType()]);
        if (isset($functionCall->args[0]) === \false) {
            return $defaultReturnType;
        }
        $firstArgument = $scope->getType($functionCall->args[0]->value);
        $firstArgumentIsPositive = $firstArgument instanceof \PHPStan\Type\ConstantScalarType && \is_numeric($firstArgument->getValue()) && $firstArgument->getValue() >= 0;
        $firstArgumentIsNegative = $firstArgument instanceof \PHPStan\Type\ConstantScalarType && \is_numeric($firstArgument->getValue()) && $firstArgument->getValue() < 0;
        if ($firstArgument instanceof \PhpParser\Node\Expr\UnaryMinus || $firstArgumentIsNegative) {
            return new \PHPStan\Type\NullType();
        }
        if (isset($functionCall->args[1]) === \false) {
            if ($firstArgumentIsPositive) {
                return $stringAndNumericStringType;
            }
            return $defaultReturnType;
        }
        $secondArgument = $scope->getType($functionCall->args[1]->value);
        $secondArgumentIsValid = $secondArgument instanceof \PHPStan\Type\ConstantScalarType && \is_numeric($secondArgument->getValue()) && !$this->isZero($secondArgument->getValue());
        $secondArgumentIsNonNumeric = $secondArgument instanceof \PHPStan\Type\ConstantScalarType && !\is_numeric($secondArgument->getValue());
        if ($secondArgumentIsNonNumeric) {
            return new \PHPStan\Type\NullType();
        }
        if ($firstArgumentIsPositive && $secondArgumentIsValid) {
            return $stringAndNumericStringType;
        }
        return $defaultReturnType;
    }
    /**
     * bcpowmod()
     * https://www.php.net/manual/en/function.bcpowmod.php
     * > Returns the result as a string, or FALSE if modulus is 0 or exponent is negative.
     * @param FuncCall $functionCall
     * @param Scope $scope
     * @return Type
     */
    private function getTypeForBcPowMod(\PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $stringAndNumericStringType = \PHPStan\Type\TypeCombinator::intersect(new \PHPStan\Type\StringType(), new \PHPStan\Type\Accessory\AccessoryNumericStringType());
        if (isset($functionCall->args[1]) === \false) {
            return new \PHPStan\Type\UnionType([$stringAndNumericStringType, new \PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        $exponent = $scope->getType($functionCall->args[1]->value);
        $exponentIsNegative = \PHPStan\Type\IntegerRangeType::fromInterval(null, 0)->isSuperTypeOf($exponent)->yes();
        if ($exponent instanceof \PHPStan\Type\ConstantScalarType) {
            $exponentIsNegative = \is_numeric($exponent->getValue()) && $exponent->getValue() < 0;
        }
        if ($exponentIsNegative) {
            return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        if (isset($functionCall->args[2])) {
            $modulus = $scope->getType($functionCall->args[2]->value);
            $modulusIsZero = $modulus instanceof \PHPStan\Type\ConstantScalarType && $this->isZero($modulus->getValue());
            $modulusIsNonNumeric = $modulus instanceof \PHPStan\Type\ConstantScalarType && !\is_numeric($modulus->getValue());
            if ($modulusIsZero || $modulusIsNonNumeric) {
                return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
            }
            if ($modulus instanceof \PHPStan\Type\ConstantScalarType) {
                return $stringAndNumericStringType;
            }
        }
        return new \PHPStan\Type\UnionType([$stringAndNumericStringType, new \PHPStan\Type\Constant\ConstantBooleanType(\false)]);
    }
    /**
     * Utility to help us determine if value is zero. Handles cases where we pass "0.000" too.
     *
     * @param mixed $value
     * @return bool
     */
    private function isZero($value) : bool
    {
        if (\is_numeric($value) === \false) {
            return \false;
        }
        if ($value > 0 || $value < 0) {
            return \false;
        }
        return \true;
    }
}
