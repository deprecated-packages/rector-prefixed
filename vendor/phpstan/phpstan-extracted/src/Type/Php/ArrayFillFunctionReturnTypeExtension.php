<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Accessory\NonEmptyArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
class ArrayFillFunctionReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    private const MAX_SIZE_USE_CONSTANT_ARRAY = 100;
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_fill';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 3) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $startIndexType = $scope->getType($functionCall->args[0]->value);
        $numberType = $scope->getType($functionCall->args[1]->value);
        $valueType = $scope->getType($functionCall->args[2]->value);
        if ($startIndexType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType && $numberType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType && $numberType->getValue() <= static::MAX_SIZE_USE_CONSTANT_ARRAY) {
            $arrayBuilder = \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
            $nextIndex = $startIndexType->getValue();
            for ($i = 0; $i < $numberType->getValue(); $i++) {
                $arrayBuilder->setOffsetValueType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType($nextIndex), $valueType);
                if ($nextIndex < 0) {
                    $nextIndex = 0;
                } else {
                    $nextIndex++;
                }
            }
            return $arrayBuilder->getArray();
        }
        if ($numberType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType && $numberType->getValue() > 0) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntersectionType([new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType(), $valueType), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Accessory\NonEmptyArrayType()]);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType(), $valueType);
    }
}
