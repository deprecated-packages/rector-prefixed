<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
class VarExportFunctionDynamicReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['var_export', 'highlight_file', 'highlight_string', 'print_r'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($functionReflection->getName() === 'var_export') {
            $fallbackReturnType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType();
        } elseif ($functionReflection->getName() === 'print_r') {
            $fallbackReturnType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\true);
        } else {
            $fallbackReturnType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType();
        }
        if (\count($functionCall->args) < 1) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType(), $fallbackReturnType);
        }
        if (\count($functionCall->args) < 2) {
            return $fallbackReturnType;
        }
        $returnArgumentType = $scope->getType($functionCall->args[1]->value);
        if ((new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($returnArgumentType)->yes()) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType();
        }
        return $fallbackReturnType;
    }
}
