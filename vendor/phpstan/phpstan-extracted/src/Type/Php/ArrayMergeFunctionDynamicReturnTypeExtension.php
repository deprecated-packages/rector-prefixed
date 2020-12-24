<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
class ArrayMergeFunctionDynamicReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'array_merge';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (!isset($functionCall->args[0])) {
            return \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        }
        $keyTypes = [];
        $valueTypes = [];
        foreach ($functionCall->args as $arg) {
            $argType = $scope->getType($arg->value);
            if ($arg->unpack) {
                $argType = $argType->getIterableValueType();
                if ($argType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType) {
                    foreach ($argType->getTypes() as $innerType) {
                        $argType = $innerType;
                    }
                }
            }
            $keyTypes[] = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::generalizeType($argType->getIterableKeyType());
            $valueTypes[] = $argType->getIterableValueType();
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(\_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$keyTypes), \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...$valueTypes));
    }
}
