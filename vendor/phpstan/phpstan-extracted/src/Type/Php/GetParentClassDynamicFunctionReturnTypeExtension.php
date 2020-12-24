<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type\Php;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Type\ClassStringType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeUtils;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
class GetParentClassDynamicFunctionReturnTypeExtension implements \_PhpScopere8e811afab72\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function isFunctionSupported(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_parent_class';
    }
    public function getTypeFromFunctionCall(\_PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $defaultReturnType = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) === 0) {
            if ($scope->isInTrait()) {
                return $defaultReturnType;
            }
            if ($scope->isInClass()) {
                return $this->findParentClassType($scope->getClassReflection());
            }
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        if ($scope->isInTrait() && \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::findThisType($argType) !== null) {
            return $defaultReturnType;
        }
        $constantStrings = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getConstantStrings($argType);
        if (\count($constantStrings) > 0) {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...\array_map(function (\_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType $stringType) : Type {
                return $this->findParentClassNameType($stringType->getValue());
            }, $constantStrings));
        }
        $classNames = \_PhpScopere8e811afab72\PHPStan\Type\TypeUtils::getDirectClassNames($argType);
        if (\count($classNames) > 0) {
            return \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::union(...\array_map(function (string $classNames) : Type {
                return $this->findParentClassNameType($classNames);
            }, $classNames));
        }
        return $defaultReturnType;
    }
    private function findParentClassNameType(string $className) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if (!$this->reflectionProvider->hasClass($className)) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\ClassStringType(), new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        return $this->findParentClassType($this->reflectionProvider->getClass($className));
    }
    private function findParentClassType(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $classReflection) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $parentClass = $classReflection->getParentClass();
        if ($parentClass === \false) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType($parentClass->getName(), \true);
    }
}
