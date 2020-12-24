<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
class VersionCompareFunctionDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'version_compare';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (\count($functionCall->args) < 2) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $functionCall->args, $functionReflection->getVariants())->getReturnType();
        }
        $version1Strings = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($functionCall->args[0]->value));
        $version2Strings = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($functionCall->args[1]->value));
        $counts = [\count($version1Strings), \count($version2Strings)];
        if (isset($functionCall->args[2])) {
            $operatorStrings = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($functionCall->args[2]->value));
            $counts[] = \count($operatorStrings);
            $returnType = new \_PhpScopere8e811afab72\PHPStan\Type\BooleanType();
        } else {
            $returnType = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(-1), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(0), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(1));
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
                        $types[$value] = new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType($value);
                    }
                } else {
                    $value = \version_compare($version1String->getValue(), $version2String->getValue());
                    $types[$value] = new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType($value);
                }
            }
        }
        return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$types);
    }
}
