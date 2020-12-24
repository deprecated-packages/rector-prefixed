<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
class ArrayFillKeysFunctionReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_fill_keys';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $valueType = $scope->getType($functionCall->args[1]->value);
        $keysType = $scope->getType($functionCall->args[0]->value);
        $constantArrays = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantArrays($keysType);
        if (\count($constantArrays) === 0) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType($keysType->getIterableValueType(), $valueType);
        }
        $arrayTypes = [];
        foreach ($constantArrays as $constantArray) {
            $arrayBuilder = \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($constantArray->getValueTypes() as $keyType) {
                $arrayBuilder->setOffsetValueType($keyType, $valueType);
            }
            $arrayTypes[] = $arrayBuilder->getArray();
        }
        return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$arrayTypes);
    }
}
