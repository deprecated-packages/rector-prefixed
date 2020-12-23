<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\BenevolentUnionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\FloatType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
class GettimeofdayDynamicFunctionReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'gettimeofday';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $arrayType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType('sec'), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType('usec'), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType('minuteswest'), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantStringType('dsttime')], [new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType()]);
        $floatType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\FloatType();
        if (!isset($functionCall->args[0])) {
            return $arrayType;
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $isTrueType = (new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($argType);
        $isFalseType = (new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false))->isSuperTypeOf($argType);
        $compareTypes = $isTrueType->compareTo($isFalseType);
        if ($compareTypes === $isTrueType) {
            return $floatType;
        }
        if ($compareTypes === $isFalseType) {
            return $arrayType;
        }
        if ($argType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\BenevolentUnionType([$arrayType, $floatType]);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType([$arrayType, $floatType]);
    }
}
