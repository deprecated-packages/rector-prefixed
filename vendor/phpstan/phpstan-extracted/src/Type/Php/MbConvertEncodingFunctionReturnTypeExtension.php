<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ArrayType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
class MbConvertEncodingFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'mb_convert_encoding';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $defaultReturnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (!isset($functionCall->args[0])) {
            return $defaultReturnType;
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $isString = (new \PHPStan\Type\StringType())->isSuperTypeOf($argType);
        $isArray = (new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()))->isSuperTypeOf($argType);
        $compare = $isString->compareTo($isArray);
        if ($compare === $isString) {
            return new \PHPStan\Type\StringType();
        } elseif ($compare === $isArray) {
            return new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType());
        }
        return $defaultReturnType;
    }
}
