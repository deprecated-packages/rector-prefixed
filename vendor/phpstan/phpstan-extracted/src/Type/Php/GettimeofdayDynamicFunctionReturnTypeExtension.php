<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
class GettimeofdayDynamicFunctionReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'gettimeofday';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $arrayType = new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType([new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType('sec'), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType('usec'), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType('minuteswest'), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType('dsttime')], [new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType()]);
        $floatType = new \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType();
        if (!isset($functionCall->args[0])) {
            return $arrayType;
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $isTrueType = (new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($argType);
        $isFalseType = (new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false))->isSuperTypeOf($argType);
        $compareTypes = $isTrueType->compareTo($isFalseType);
        if ($compareTypes === $isTrueType) {
            return $floatType;
        }
        if ($compareTypes === $isFalseType) {
            return $arrayType;
        }
        if ($argType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\BenevolentUnionType([$arrayType, $floatType]);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([$arrayType, $floatType]);
    }
}
