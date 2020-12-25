<?php

declare (strict_types=1);
namespace PHPStan\Type\Php;

use PhpParser\Node\Expr\FuncCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionReflection;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeUtils;
use PHPStan\Type\UnionType;
class GetParentClassDynamicFunctionReturnTypeExtension implements \PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function isFunctionSupported(\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_parent_class';
    }
    public function getTypeFromFunctionCall(\PHPStan\Reflection\FunctionReflection $functionReflection, \PhpParser\Node\Expr\FuncCall $functionCall, \PHPStan\Analyser\Scope $scope) : \PHPStan\Type\Type
    {
        $defaultReturnType = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) === 0) {
            if ($scope->isInTrait()) {
                return $defaultReturnType;
            }
            if ($scope->isInClass()) {
                return $this->findParentClassType($scope->getClassReflection());
            }
            return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        if ($scope->isInTrait() && \PHPStan\Type\TypeUtils::findThisType($argType) !== null) {
            return $defaultReturnType;
        }
        $constantStrings = \PHPStan\Type\TypeUtils::getConstantStrings($argType);
        if (\count($constantStrings) > 0) {
            return \PHPStan\Type\TypeCombinator::union(...\array_map(function (\PHPStan\Type\Constant\ConstantStringType $stringType) : Type {
                return $this->findParentClassNameType($stringType->getValue());
            }, $constantStrings));
        }
        $classNames = \PHPStan\Type\TypeUtils::getDirectClassNames($argType);
        if (\count($classNames) > 0) {
            return \PHPStan\Type\TypeCombinator::union(...\array_map(function (string $classNames) : Type {
                return $this->findParentClassNameType($classNames);
            }, $classNames));
        }
        return $defaultReturnType;
    }
    private function findParentClassNameType(string $className) : \PHPStan\Type\Type
    {
        if (!$this->reflectionProvider->hasClass($className)) {
            return new \PHPStan\Type\UnionType([new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        return $this->findParentClassType($this->reflectionProvider->getClass($className));
    }
    private function findParentClassType(\PHPStan\Reflection\ClassReflection $classReflection) : \PHPStan\Type\Type
    {
        $parentClass = $classReflection->getParentClass();
        if ($parentClass === \false) {
            return new \PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        return new \PHPStan\Type\Constant\ConstantStringType($parentClass->getName(), \true);
    }
}
