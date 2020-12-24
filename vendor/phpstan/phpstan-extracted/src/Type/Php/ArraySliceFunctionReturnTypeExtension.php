<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
class ArraySliceFunctionReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_slice';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $arrayArg = $functionCall->args[0]->value ?? null;
        if ($arrayArg === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
        }
        $valueType = $scope->getType($arrayArg);
        if (isset($functionCall->args[1])) {
            $offset = $scope->getType($functionCall->args[1]->value);
            if (!$offset instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType) {
                $offset = new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType(0);
            }
        } else {
            $offset = new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType(0);
        }
        if (isset($functionCall->args[2])) {
            $limit = $scope->getType($functionCall->args[2]->value);
            if (!$limit instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantIntegerType) {
                $limit = new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType();
            }
        } else {
            $limit = new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType();
        }
        $constantArrays = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantArrays($valueType);
        if (\count($constantArrays) === 0) {
            $arrays = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getArrays($valueType);
            if (\count($arrays) !== 0) {
                return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$arrays);
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
        }
        if (isset($functionCall->args[3])) {
            $preserveKeys = $scope->getType($functionCall->args[3]->value);
            $preserveKeys = (new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($preserveKeys)->yes();
        } else {
            $preserveKeys = \false;
        }
        $arrayTypes = \array_map(static function (\_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType $constantArray) use($offset, $limit, $preserveKeys) : ConstantArrayType {
            return $constantArray->slice($offset->getValue(), $limit->getValue(), $preserveKeys);
        }, $constantArrays);
        return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...$arrayTypes);
    }
}
