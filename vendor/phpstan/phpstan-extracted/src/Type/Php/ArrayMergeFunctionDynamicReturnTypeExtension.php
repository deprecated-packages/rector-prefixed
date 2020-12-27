<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
use PHPStan\Type\UnionType;
class ArrayMergeFunctionDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_merge';
    }
    public function getTypeFromFunctionCall(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (!isset($functionCall->args[0])) {
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $keyTypes = [];
        $valueTypes = [];
        foreach ($functionCall->args as $arg) {
            $argType = $scope->getType($arg->value);
            if ($arg->unpack) {
                $argType = $argType->getIterableValueType();
                if ($argType instanceof \PHPStan\Type\UnionType) {
                    foreach ($argType->getTypes() as $innerType) {
                        $argType = $innerType;
                    }
                }
            }
            $keyTypes[] = \PHPStan\Type\TypeUtils::generalizeType($argType->getIterableKeyType());
            $valueTypes[] = $argType->getIterableValueType();
        }
        return new \PHPStan\Type\ArrayType(\PHPStan\Type\TypeCombinator::union(...$keyTypes), \PHPStan\Type\TypeCombinator::union(...$valueTypes));
    }
}
