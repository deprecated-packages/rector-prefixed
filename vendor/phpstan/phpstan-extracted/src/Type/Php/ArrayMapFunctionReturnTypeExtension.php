<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\TypeUtils;
class ArrayMapFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_map';
    }
    public function getTypeFromFunctionCall(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $valueType = new \PHPStan\Type\MixedType();
        $callableType = $scope->getType($functionCall->args[0]->value);
        if (!$callableType->isCallable()->no()) {
            $valueType = \RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $functionCall->args, $callableType->getCallableParametersAcceptors($scope))->getReturnType();
        }
        $arrayType = $scope->getType($functionCall->args[1]->value);
        $constantArrays = \PHPStan\Type\TypeUtils::getConstantArrays($arrayType);
        if (\count($constantArrays) > 0) {
            $arrayTypes = [];
            foreach ($constantArrays as $constantArray) {
                $returnedArrayBuilder = \PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
                foreach ($constantArray->getKeyTypes() as $keyType) {
                    $returnedArrayBuilder->setOffsetValueType($keyType, $valueType);
                }
                $arrayTypes[] = $returnedArrayBuilder->getArray();
            }
            return \PHPStan\Type\TypeCombinator::union(...$arrayTypes);
        } elseif ($arrayType->isArray()->yes()) {
            return \PHPStan\Type\TypeCombinator::intersect(new \PHPStan\Type\ArrayType($arrayType->getIterableKeyType(), $valueType), ...\PHPStan\Type\TypeUtils::getAccessoryTypes($arrayType));
        }
        return new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $valueType);
    }
}
