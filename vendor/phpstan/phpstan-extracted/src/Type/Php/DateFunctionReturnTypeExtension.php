<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use RectorPrefix20201227\PHPStan\Analyser\Scope;
use RectorPrefix20201227\PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\Accessory\AccessoryNumericStringType;
use PHPStan\Type\DynamicFunctionReturnTypeExtension;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeUtils;
class DateFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'date';
    }
    public function getTypeFromFunctionCall(\RectorPrefix20201227\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \RectorPrefix20201227\PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        if (\count($functionCall->args) === 0) {
            return new \PHPStan\Type\StringType();
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        $constantStrings = \PHPStan\Type\TypeUtils::getConstantStrings($argType);
        if (\count($constantStrings) === 0) {
            return new \PHPStan\Type\StringType();
        }
        foreach ($constantStrings as $constantString) {
            $formattedDate = \date($constantString->getValue());
            if (!\is_numeric($formattedDate)) {
                return new \PHPStan\Type\StringType();
            }
        }
        return new \PHPStan\Type\IntersectionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\Accessory\AccessoryNumericStringType()]);
    }
}
