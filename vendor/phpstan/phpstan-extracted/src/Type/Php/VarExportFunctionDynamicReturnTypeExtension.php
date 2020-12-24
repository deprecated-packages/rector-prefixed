<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper0a6b37af0871\PHPStan\Type\NullType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator;
class VarExportFunctionDynamicReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['var_export', 'highlight_file', 'highlight_string', 'print_r'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if ($functionReflection->getName() === 'var_export') {
            $fallbackReturnType = new \_PhpScoper0a6b37af0871\PHPStan\Type\NullType();
        } elseif ($functionReflection->getName() === 'print_r') {
            $fallbackReturnType = new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\true);
        } else {
            $fallbackReturnType = new \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType();
        }
        if (\count($functionCall->args) < 1) {
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType(), $fallbackReturnType);
        }
        if (\count($functionCall->args) < 2) {
            return $fallbackReturnType;
        }
        $returnArgumentType = $scope->getType($functionCall->args[1]->value);
        if ((new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($returnArgumentType)->yes()) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType();
        }
        return $fallbackReturnType;
    }
}
