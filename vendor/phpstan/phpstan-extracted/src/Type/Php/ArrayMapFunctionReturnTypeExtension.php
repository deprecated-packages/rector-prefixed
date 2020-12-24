<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils;
class ArrayMapFunctionReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_map';
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $valueType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
        $callableType = $scope->getType($functionCall->args[0]->value);
        if (!$callableType->isCallable()->no()) {
            $valueType = \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $functionCall->args, $callableType->getCallableParametersAcceptors($scope))->getReturnType();
        }
        $arrayType = $scope->getType($functionCall->args[1]->value);
        $constantArrays = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::getConstantArrays($arrayType);
        if (\count($constantArrays) > 0) {
            $arrayTypes = [];
            foreach ($constantArrays as $constantArray) {
                $returnedArrayBuilder = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
                foreach ($constantArray->getKeyTypes() as $keyType) {
                    $returnedArrayBuilder->setOffsetValueType($keyType, $valueType);
                }
                $arrayTypes[] = $returnedArrayBuilder->getArray();
            }
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union(...$arrayTypes);
        } elseif ($arrayType->isArray()->yes()) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::intersect(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType($arrayType->getIterableKeyType(), $valueType), ...\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::getAccessoryTypes($arrayType));
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType(), $valueType);
    }
}
