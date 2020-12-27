<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\BenevolentUnionType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
class GettimeofdayDynamicFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'gettimeofday';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $arrayType = new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('sec'), new \PHPStan\Type\Constant\ConstantStringType('usec'), new \PHPStan\Type\Constant\ConstantStringType('minuteswest'), new \PHPStan\Type\Constant\ConstantStringType('dsttime')], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType()]);
        $floatType = new \PHPStan\Type\FloatType();
        if (!isset($functionCall->args[0])) {
            return $arrayType;
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $isTrueType = (new \PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($argType);
        $isFalseType = (new \PHPStan\Type\Constant\ConstantBooleanType(\false))->isSuperTypeOf($argType);
        $compareTypes = $isTrueType->compareTo($isFalseType);
        if ($compareTypes === $isTrueType) {
            return $floatType;
        }
        if ($compareTypes === $isFalseType) {
            return $arrayType;
        }
        if ($argType instanceof \PHPStan\Type\MixedType) {
            return new \PHPStan\Type\BenevolentUnionType([$arrayType, $floatType]);
        }
        return new \PHPStan\Type\UnionType([$arrayType, $floatType]);
    }
}
