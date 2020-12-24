<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Php;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PHPStan\Analyser\Scope;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
class GetParentClassDynamicFunctionReturnTypeExtension implements \_PhpScoper0a6b37af0871\PHPStan\Type\DynamicFunctionReturnTypeExtension
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function isFunctionSupported(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection) : bool
    {
        return $functionReflection->getName() === 'get_parent_class';
    }
    public function getTypeFromFunctionCall(\_PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection $functionReflection, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall $functionCall, \_PhpScoper0a6b37af0871\PHPStan\Analyser\Scope $scope) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $defaultReturnType = \_PhpScoper0a6b37af0871\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants())->getReturnType();
        if (\count($functionCall->args) === 0) {
            if ($scope->isInTrait()) {
                return $defaultReturnType;
            }
            if ($scope->isInClass()) {
                return $this->findParentClassType($scope->getClassReflection());
            }
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        $argType = $scope->getType($functionCall->args[0]->value);
        if ($scope->isInTrait() && \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::findThisType($argType) !== null) {
            return $defaultReturnType;
        }
        $constantStrings = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getConstantStrings($argType);
        if (\count($constantStrings) > 0) {
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...\array_map(function (\_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType $stringType) : Type {
                return $this->findParentClassNameType($stringType->getValue());
            }, $constantStrings));
        }
        $classNames = \_PhpScoper0a6b37af0871\PHPStan\Type\TypeUtils::getDirectClassNames($argType);
        if (\count($classNames) > 0) {
            return \_PhpScoper0a6b37af0871\PHPStan\Type\TypeCombinator::union(...\array_map(function (string $classNames) : Type {
                return $this->findParentClassNameType($classNames);
            }, $classNames));
        }
        return $defaultReturnType;
    }
    private function findParentClassNameType(string $className) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        if (!$this->reflectionProvider->hasClass($className)) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\ClassStringType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false)]);
        }
        return $this->findParentClassType($this->reflectionProvider->getClass($className));
    }
    private function findParentClassType(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassReflection $classReflection) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type
    {
        $parentClass = $classReflection->getParentClass();
        if ($parentClass === \false) {
            return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\false);
        }
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantStringType($parentClass->getName(), \true);
    }
}
