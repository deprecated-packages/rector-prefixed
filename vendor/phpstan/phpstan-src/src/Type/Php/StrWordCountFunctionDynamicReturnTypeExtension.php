<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PHPStan\Analyser\Scope;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
class StrWordCountFunctionDynamicReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'str_word_count';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $argsCount = \count($functionCall->args);
        if ($argsCount === 1) {
            return new \PHPStan\Type\IntegerType();
        } elseif ($argsCount === 2 || $argsCount === 3) {
            $formatType = $scope->getType($functionCall->args[1]->value);
            if ($formatType instanceof \PHPStan\Type\Constant\ConstantIntegerType) {
                $val = $formatType->getValue();
                if ($val === 0) {
                    // return word count
                    return new \PHPStan\Type\IntegerType();
                } elseif ($val === 1 || $val === 2) {
                    // return [word] or [offset => word]
                    return new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType());
                }
                // return false, invalid format value specified
                return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
            }
            // Could be invalid format type as well, but parameter type checks will catch that.
            return new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        // else fatal error; too many or too few arguments
        return new \PHPStan\Type\ErrorType();
    }
}
