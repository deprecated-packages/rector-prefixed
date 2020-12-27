<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
class CurlInitReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'curl_init';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $argsCount = \count($functionCall->args);
        $returnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if ($argsCount === 0) {
            return \PHPStan\Type\TypeCombinator::remove($returnType, new \PHPStan\Type\Constant\ConstantBooleanType(\false));
        }
        return $returnType;
    }
}
