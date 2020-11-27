<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ConstantScalarType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
class SprintfFunctionDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'sprintf';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $values = [];
        $returnType = new \PHPStan\Type\StringType();
        foreach ($functionCall->args as $arg) {
            $argType = $scope->getType($arg->value);
            if (!$argType instanceof \PHPStan\Type\ConstantScalarType) {
                return $returnType;
            }
            $values[] = $argType->getValue();
        }
        if (\count($values) === 0) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $format = \array_shift($values);
        if (!\is_string($format)) {
            return \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        try {
            $value = @\sprintf($format, ...$values);
        } catch (\Throwable $e) {
            return $returnType;
        }
        return $scope->getTypeFromValue($value);
    }
}
