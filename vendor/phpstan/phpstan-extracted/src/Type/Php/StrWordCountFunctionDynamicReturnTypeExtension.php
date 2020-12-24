<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Php;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
class StrWordCountFunctionDynamicReturnTypeExtension implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'str_word_count';
    }
    public function getTypeFromFunctionCall(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $argsCount = \count($functionCall->args);
        if ($argsCount === 1) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType();
        } elseif ($argsCount === 2 || $argsCount === 3) {
            $formatType = $scope->getType($functionCall->args[1]->value);
            if ($formatType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantIntegerType) {
                $val = $formatType->getValue();
                if ($val === 0) {
                    // return word count
                    return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType();
                } elseif ($val === 1 || $val === 2) {
                    // return [word] or [offset => word]
                    return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType());
                }
                // return false, invalid format value specified
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false);
            }
            // Could be invalid format type as well, but parameter type checks will catch that.
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType(new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType(), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType()), new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        // else fatal error; too many or too few arguments
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ErrorType();
    }
}
