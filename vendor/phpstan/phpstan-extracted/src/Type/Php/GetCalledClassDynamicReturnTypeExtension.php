<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class GetCalledClassDynamicReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_called_class';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $classContext = $scope->getClassReflection();
        if ($classContext !== null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType($classContext->getName(), \true);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
}
