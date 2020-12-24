<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
final class DsMapDynamicReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicMethodReturnTypeExtension
{
    public function getClass() : string
    {
        return '_PhpScopere8e811afab72\\Ds\\Map';
    }
    public function isMethodSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection) : bool
    {
        return $methodReflection->getName() === 'get' || $methodReflection->getName() === 'remove';
    }
    public function getTypeFromMethodCall(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $methodReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $returnType = $methodReflection->getVariants()[0]->getReturnType();
        if (\count($methodCall->args) > 1) {
            return \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectFromArgs($scope, $methodCall->args, $methodReflection->getVariants())->getReturnType();
        }
        if ($returnType instanceof \_PhpScopere8e811afab72\PHPStan\Type\UnionType) {
            $types = \array_values(\array_filter($returnType->getTypes(), static function (\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool {
                return !$type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateType;
            }));
            if (\count($types) === 1) {
                return $types[0];
            }
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...$types);
        }
        return $returnType;
    }
}
