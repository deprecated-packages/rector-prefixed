<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\BenevolentUnionType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
class Base64DecodeDynamicFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'base64_decode';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (!isset($functionCall->args[1])) {
            return new \PHPStan\Type\StringType();
        }
        $argType = $scope->getType($functionCall->args[1]->value);
        if ($argType instanceof \PHPStan\Type\MixedType) {
            return new \PHPStan\Type\BenevolentUnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        $isTrueType = (new \PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($argType);
        $isFalseType = (new \PHPStan\Type\Constant\ConstantBooleanType(\false))->isSuperTypeOf($argType);
        $compareTypes = $isTrueType->compareTo($isFalseType);
        if ($compareTypes === $isTrueType) {
            return new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        if ($compareTypes === $isFalseType) {
            return new \PHPStan\Type\StringType();
        }
        // second argument could be interpreted as true
        if (!$isTrueType->no()) {
            return new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        return new \PHPStan\Type\StringType();
    }
}
