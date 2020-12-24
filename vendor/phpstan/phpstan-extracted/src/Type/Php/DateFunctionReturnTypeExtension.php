<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\Accessory\AccessoryNumericStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
class DateFunctionReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'date';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (\count($functionCall->args) === 0) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType();
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $constantStrings = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantStrings($argType);
        if (\count($constantStrings) === 0) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType();
        }
        foreach ($constantStrings as $constantString) {
            $formattedDate = \date($constantString->getValue());
            if (!\is_numeric($formattedDate)) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType();
            }
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\Accessory\AccessoryNumericStringType()]);
    }
}
