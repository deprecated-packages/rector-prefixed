<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\FloatType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils;
class HrtimeFunctionReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'hrtime';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $arrayType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType(0), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType(1)], [new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType()], 2);
        $numberType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::toBenevolentUnion(\_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\FloatType()));
        if (\count($functionCall->args) < 1) {
            return $arrayType;
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $isTrueType = (new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($argType);
        $isFalseType = (new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false))->isSuperTypeOf($argType);
        $compareTypes = $isTrueType->compareTo($isFalseType);
        if ($compareTypes === $isTrueType) {
            return $numberType;
        }
        if ($compareTypes === $isFalseType) {
            return $arrayType;
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union($arrayType, $numberType);
    }
}
