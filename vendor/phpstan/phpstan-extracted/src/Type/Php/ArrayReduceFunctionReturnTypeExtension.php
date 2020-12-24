<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
class ArrayReduceFunctionReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_reduce';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (!isset($functionCall->args[1])) {
            return \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $callbackType = $scope->getType($functionCall->args[1]->value);
        if ($callbackType->isCallable()->no()) {
            return \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $callbackReturnType = \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $functionCall->args, $callbackType->getCallableParametersAcceptors($scope))->getReturnType();
        if (isset($functionCall->args[2])) {
            $initialType = $scope->getType($functionCall->args[2]->value);
        } else {
            $initialType = new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
        }
        $arraysType = $scope->getType($functionCall->args[0]->value);
        $constantArrays = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantArrays($arraysType);
        if (\count($constantArrays) > 0) {
            $onlyEmpty = \true;
            $onlyNonEmpty = \true;
            foreach ($constantArrays as $constantArray) {
                $isEmpty = \count($constantArray->getValueTypes()) === 0;
                $onlyEmpty = $onlyEmpty && $isEmpty;
                $onlyNonEmpty = $onlyNonEmpty && !$isEmpty;
            }
            if ($onlyEmpty) {
                return $initialType;
            }
            if ($onlyNonEmpty) {
                return $callbackReturnType;
            }
        }
        return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union($callbackReturnType, $initialType);
    }
}
