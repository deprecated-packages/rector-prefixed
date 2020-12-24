<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
class ArrayFillKeysFunctionReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_fill_keys';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $valueType = $scope->getType($functionCall->args[1]->value);
        $keysType = $scope->getType($functionCall->args[0]->value);
        $constantArrays = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantArrays($keysType);
        if (\count($constantArrays) === 0) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType($keysType->getIterableValueType(), $valueType);
        }
        $arrayTypes = [];
        foreach ($constantArrays as $constantArray) {
            $arrayBuilder = \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            foreach ($constantArray->getValueTypes() as $keyType) {
                $arrayBuilder->setOffsetValueType($keyType, $valueType);
            }
            $arrayTypes[] = $arrayBuilder->getArray();
        }
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$arrayTypes);
    }
}
