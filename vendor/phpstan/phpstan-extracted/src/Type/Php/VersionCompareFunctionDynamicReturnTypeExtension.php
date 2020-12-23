<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Php;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils;
class VersionCompareFunctionDynamicReturnTypeExtension implements \_PhpScoper0a2ac50786fa\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'version_compare';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a2ac50786fa\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $functionCall->args, $functionReflection->getVariants())->getReturnType();
        }
        $version1Strings = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($functionCall->args[0]->value));
        $version2Strings = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($functionCall->args[1]->value));
        $counts = [\count($version1Strings), \count($version2Strings)];
        if (isset($functionCall->args[2])) {
            $operatorStrings = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($functionCall->args[2]->value));
            $counts[] = \count($operatorStrings);
            $returnType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType();
        } else {
            $returnType = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType(-1), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType(0), new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType(1));
        }
        if (\count(\array_filter($counts, static function (int $count) : bool {
            return $count === 0;
        })) > 0) {
            return $returnType;
            // one of the arguments is not a constant string
        }
        if (\count(\array_filter($counts, static function (int $count) : bool {
            return $count > 1;
        })) > 1) {
            return $returnType;
            // more than one argument can have multiple possibilities, avoid combinatorial explosion
        }
        $types = [];
        foreach ($version1Strings as $version1String) {
            foreach ($version2Strings as $version2String) {
                if (isset($operatorStrings)) {
                    foreach ($operatorStrings as $operatorString) {
                        $value = \version_compare($version1String->getValue(), $version2String->getValue(), $operatorString->getValue());
                        $types[$value] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType($value);
                    }
                } else {
                    $value = \version_compare($version1String->getValue(), $version2String->getValue());
                    $types[$value] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantIntegerType($value);
                }
            }
        }
        return \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeCombinator::union(...$types);
    }
}
