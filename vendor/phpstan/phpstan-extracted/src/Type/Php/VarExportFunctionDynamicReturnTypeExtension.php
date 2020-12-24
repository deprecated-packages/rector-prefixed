<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator;
class VarExportFunctionDynamicReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return \in_array($functionReflection->getName(), ['var_export', 'highlight_file', 'highlight_string', 'print_r'], \true);
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($functionReflection->getName() === 'var_export') {
            $fallbackReturnType = new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType();
        } elseif ($functionReflection->getName() === 'print_r') {
            $fallbackReturnType = new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\true);
        } else {
            $fallbackReturnType = new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType();
        }
        if (\count($functionCall->args) < 1) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(), $fallbackReturnType);
        }
        if (\count($functionCall->args) < 2) {
            return $fallbackReturnType;
        }
        $returnArgumentType = $scope->getType($functionCall->args[1]->value);
        if ((new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\true))->isSuperTypeOf($returnArgumentType)->yes()) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType();
        }
        return $fallbackReturnType;
    }
}
