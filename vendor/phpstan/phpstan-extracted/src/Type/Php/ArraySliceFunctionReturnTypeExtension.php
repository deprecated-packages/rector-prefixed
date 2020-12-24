<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
class ArraySliceFunctionReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_slice';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $arrayArg = $functionCall->args[0]->value ?? null;
        if ($arrayArg === null) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
        }
        $valueType = $scope->getType($arrayArg);
        if (isset($functionCall->args[1])) {
            $offset = $scope->getType($functionCall->args[1]->value);
            if (!$offset instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
                $offset = new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType(0);
            }
        } else {
            $offset = new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType(0);
        }
        if (isset($functionCall->args[2])) {
            $limit = $scope->getType($functionCall->args[2]->value);
            if (!$limit instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantIntegerType) {
                $limit = new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
            }
        } else {
            $limit = new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
        }
        $constantArrays = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantArrays($valueType);
        if (\count($constantArrays) === 0) {
            $arrays = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getArrays($valueType);
            if (\count($arrays) !== 0) {
                return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$arrays);
            }
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
        }
        if (isset($functionCall->args[3])) {
            $preserveKeys = $scope->getType($functionCall->args[3]->value);
            $preserveKeys = (new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($preserveKeys)->yes();
        } else {
            $preserveKeys = \false;
        }
        $arrayTypes = \array_map(static function (\_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantArrayType $constantArray) use($offset, $limit, $preserveKeys) : ConstantArrayType {
            return $constantArray->slice($offset->getValue(), $limit->getValue(), $preserveKeys);
        }, $constantArrays);
        return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$arrayTypes);
    }
}
