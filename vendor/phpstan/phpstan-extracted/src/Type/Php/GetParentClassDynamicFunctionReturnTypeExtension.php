<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Php;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PHPStan\Analyser\Scope;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
class GetParentClassDynamicFunctionReturnTypeExtension implements \_PhpScoperb75b35f52b74\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function isFunctionSupported(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_parent_class';
    }
    public function getTypeFromFunctionCall(\_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $scope) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $defaultReturnType = \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) === 0) {
            if ($scope->isInTrait()) {
                return $defaultReturnType;
            }
            if ($scope->isInClass()) {
                return $this->findParentClassType($scope->getClassReflection());
            }
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        if ($scope->isInTrait() && \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::findThisType($argType) !== null) {
            return $defaultReturnType;
        }
        $constantStrings = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getConstantStrings($argType);
        if (\count($constantStrings) > 0) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...\array_map(function (\_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType $stringType) : Type {
                return $this->findParentClassNameType($stringType->getValue());
            }, $constantStrings));
        }
        $classNames = \_PhpScoperb75b35f52b74\PHPStan\Type\TypeUtils::getDirectClassNames($argType);
        if (\count($classNames) > 0) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\TypeCombinator::union(...\array_map(function (string $classNames) : Type {
                return $this->findParentClassNameType($classNames);
            }, $classNames));
        }
        return $defaultReturnType;
    }
    private function findParentClassNameType(string $className) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if (!$this->reflectionProvider->hasClass($className)) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\ClassStringType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        return $this->findParentClassType($this->reflectionProvider->getClass($className));
    }
    private function findParentClassType(\_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection $classReflection) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $parentClass = $classReflection->getParentClass();
        if ($parentClass === \false) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantStringType($parentClass->getName(), \true);
    }
}
