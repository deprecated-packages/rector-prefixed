<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils;
class ArrayFillKeysFunctionReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_fill_keys';
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $valueType = $scope->getType($functionCall->args[1]->value);
        $keysType = $scope->getType($functionCall->args[0]->value);
        $constantArrays = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeUtils::getConstantArrays($keysType);
        if (\count($constantArrays) === 0) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType($keysType->getIterableValueType(), $valueType);
        }
        $arrayTypes = [];
        foreach ($constantArrays as $constantArray) {
            $arrayBuilder = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($constantArray->getValueTypes() as $keyType) {
                $arrayBuilder->setOffsetValueType($keyType, $valueType);
            }
            $arrayTypes[] = $arrayBuilder->getArray();
        }
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeCombinator::union(...$arrayTypes);
    }
}
