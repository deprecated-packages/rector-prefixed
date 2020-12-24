<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
class ArrayMapFunctionReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_map';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $valueType = new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType();
        $callableType = $scope->getType($functionCall->args[0]->value);
        if (!$callableType->isCallable()->no()) {
            $valueType = \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $functionCall->args, $callableType->getCallableParametersAcceptors($scope))->getReturnType();
        }
        $arrayType = $scope->getType($functionCall->args[1]->value);
        $constantArrays = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantArrays($arrayType);
        if (\count($constantArrays) > 0) {
            $arrayTypes = [];
            foreach ($constantArrays as $constantArray) {
                $returnedArrayBuilder = \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
                foreach ($constantArray->getKeyTypes() as $keyType) {
                    $returnedArrayBuilder->setOffsetValueType($keyType, $valueType);
                }
                $arrayTypes[] = $returnedArrayBuilder->getArray();
            }
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$arrayTypes);
        } elseif ($arrayType->isArray()->yes()) {
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::intersect(new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType($arrayType->getIterableKeyType(), $valueType), ...\_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getAccessoryTypes($arrayType));
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $valueType);
    }
}
