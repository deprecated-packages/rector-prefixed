<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
class ArrayPointerFunctionsDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var string[] */
    private $functions = ['reset', 'end'];
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), $this->functions, \true);
    }
    public function getTypeFromFunctionCall(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($functionCall->args) === 0) {
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $iterableAtLeastOnce = $argType->isIterableAtLeastOnce();
        if ($iterableAtLeastOnce->no()) {
            return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $constantArrays = \PHPStan\Type\TypeUtils::getConstantArrays($argType);
        if (\count($constantArrays) > 0) {
            $keyTypes = [];
            foreach ($constantArrays as $constantArray) {
                $arrayKeyTypes = $constantArray->getKeyTypes();
                if (\count($arrayKeyTypes) === 0) {
                    $keyTypes[] = new \PHPStan\Type\Constant\ConstantBooleanType(\false);
                    continue;
                }
                $valueOffset = $functionReflection->getName() === 'reset' ? $arrayKeyTypes[0] : $arrayKeyTypes[\count($arrayKeyTypes) - 1];
                $keyTypes[] = $constantArray->getOffsetValueType($valueOffset);
            }
            return \PHPStan\Type\TypeCombinator::union(...$keyTypes);
        }
        $itemType = $argType->getIterableValueType();
        if ($iterableAtLeastOnce->yes()) {
            return $itemType;
        }
        return \PHPStan\Type\TypeCombinator::union($itemType, new \PHPStan\Type\Constant\ConstantBooleanType(\false));
    }
}
