<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryMinus;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\Accessory\AccessoryNumericStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use function in_array;
use function is_numeric;
class BcMathStringOrNullReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['bcdiv', 'bcmod', 'bcpowmod', 'bcsqrt'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($functionReflection->getName() === 'bcsqrt') {
            return $this->getTypeForBcSqrt($functionCall, $scope);
        }
        if ($functionReflection->getName() === 'bcpowmod') {
            return $this->getTypeForBcPowMod($functionCall, $scope);
        }
        $stringAndNumericStringType = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::intersect(new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\AccessoryNumericStringType());
        $defaultReturnType = new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([$stringAndNumericStringType, new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType()]);
        if (isset($functionCall->args[1]) === \false) {
            return $stringAndNumericStringType;
        }
        $secondArgument = $scope->getType($functionCall->args[1]->value);
        $secondArgumentIsNumeric = $secondArgument instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && \is_numeric($secondArgument->getValue()) || $secondArgument instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
        if ($secondArgument instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && ($this->isZero($secondArgument->getValue()) || !$secondArgumentIsNumeric)) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
        }
        if (isset($functionCall->args[2]) === \false) {
            if ($secondArgument instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType || $secondArgumentIsNumeric) {
                return $stringAndNumericStringType;
            }
            return $defaultReturnType;
        }
        $thirdArgument = $scope->getType($functionCall->args[2]->value);
        $thirdArgumentIsNumeric = $thirdArgument instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && \is_numeric($thirdArgument->getValue()) || $thirdArgument instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
        if ($thirdArgument instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && !\is_numeric($thirdArgument->getValue())) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
        }
        if (($secondArgument instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType || $secondArgumentIsNumeric) && $thirdArgumentIsNumeric) {
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
    private function getTypeForBcSqrt(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $stringAndNumericStringType = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::intersect(new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\AccessoryNumericStringType());
        $defaultReturnType = new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([$stringAndNumericStringType, new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType()]);
        if (isset($functionCall->args[0]) === \false) {
            return $defaultReturnType;
        }
        $firstArgument = $scope->getType($functionCall->args[0]->value);
        $firstArgumentIsPositive = $firstArgument instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && \is_numeric($firstArgument->getValue()) && $firstArgument->getValue() >= 0;
        $firstArgumentIsNegative = $firstArgument instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && \is_numeric($firstArgument->getValue()) && $firstArgument->getValue() < 0;
        if ($firstArgument instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\UnaryMinus || $firstArgumentIsNegative) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
        }
        if (isset($functionCall->args[1]) === \false) {
            if ($firstArgumentIsPositive) {
                return $stringAndNumericStringType;
            }
            return $defaultReturnType;
        }
        $secondArgument = $scope->getType($functionCall->args[1]->value);
        $secondArgumentIsValid = $secondArgument instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && \is_numeric($secondArgument->getValue()) && !$this->isZero($secondArgument->getValue());
        $secondArgumentIsNonNumeric = $secondArgument instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && !\is_numeric($secondArgument->getValue());
        if ($secondArgumentIsNonNumeric) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
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
    private function getTypeForBcPowMod(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $stringAndNumericStringType = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::intersect(new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\Accessory\AccessoryNumericStringType());
        if (isset($functionCall->args[1]) === \false) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([$stringAndNumericStringType, new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        $exponent = $scope->getType($functionCall->args[1]->value);
        $exponentIsNegative = \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerRangeType::fromInterval(null, 0)->isSuperTypeOf($exponent)->yes();
        if ($exponent instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType) {
            $exponentIsNegative = \is_numeric($exponent->getValue()) && $exponent->getValue() < 0;
        }
        if ($exponentIsNegative) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        if (isset($functionCall->args[2])) {
            $modulus = $scope->getType($functionCall->args[2]->value);
            $modulusIsZero = $modulus instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && $this->isZero($modulus->getValue());
            $modulusIsNonNumeric = $modulus instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType && !\is_numeric($modulus->getValue());
            if ($modulusIsZero || $modulusIsNonNumeric) {
                return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
            }
            if ($modulus instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantScalarType) {
                return $stringAndNumericStringType;
            }
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([$stringAndNumericStringType, new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false)]);
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
