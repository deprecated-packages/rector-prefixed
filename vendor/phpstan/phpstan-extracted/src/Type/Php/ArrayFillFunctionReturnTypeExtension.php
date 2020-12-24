<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class ArrayFillFunctionReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private const MAX_SIZE_USE_CONSTANT_ARRAY = 100;
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_fill';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 3) {
            return \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $startIndexType = $scope->getType($functionCall->args[0]->value);
        $numberType = $scope->getType($functionCall->args[1]->value);
        $valueType = $scope->getType($functionCall->args[2]->value);
        if ($startIndexType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType && $numberType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType && $numberType->getValue() <= static::MAX_SIZE_USE_CONSTANT_ARRAY) {
            $arrayBuilder = \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            $nextIndex = $startIndexType->getValue();
            for ($i = 0; $i < $numberType->getValue(); $i++) {
                $arrayBuilder->setOffsetValueType(new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType($nextIndex), $valueType);
                if ($nextIndex < 0) {
                    $nextIndex = 0;
                } else {
                    $nextIndex++;
                }
            }
            return $arrayBuilder->getArray();
        }
        if ($numberType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType && $numberType->getValue() > 0) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), $valueType), new \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\NonEmptyArrayType()]);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), $valueType);
    }
}
