<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeAndMethod;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface;
/**
 * @see https://github.com/phpstan/phpstan-src/blob/b1fd47bda2a7a7d25091197b125c0adf82af6757/src/Type/Constant/ConstantArrayType.php#L188
 */
final class ConstantArrayTypeToCallReflectionResolver implements \_PhpScopere8e811afab72\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface
{
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function supports(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType;
    }
    /**
     * @param ConstantArrayType $type
     */
    public function resolve(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer) : ?\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
    {
        $constantArrayTypeAndMethod = $this->findTypeAndMethodName($type);
        if ($constantArrayTypeAndMethod === null) {
            return null;
        }
        if ($constantArrayTypeAndMethod->isUnknown() || !$constantArrayTypeAndMethod->getCertainty()->yes()) {
            return null;
        }
        $constantArrayType = $constantArrayTypeAndMethod->getType();
        $methodReflection = $constantArrayType->getMethod($constantArrayTypeAndMethod->getMethod(), $classMemberAccessAnswerer);
        if (!$classMemberAccessAnswerer->canCallMethod($methodReflection)) {
            return null;
        }
        return $methodReflection;
    }
    /**
     * @see https://github.com/phpstan/phpstan-src/blob/b1fd47bda2a7a7d25091197b125c0adf82af6757/src/Type/Constant/ConstantArrayType.php#L209
     */
    private function findTypeAndMethodName(\_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType $constantArrayType) : ?\_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeAndMethod
    {
        if (!$this->areKeyTypesValid($constantArrayType)) {
            return null;
        }
        if (\count($constantArrayType->getValueTypes()) !== 2) {
            return null;
        }
        $classOrObjectType = $constantArrayType->getValueTypes()[0];
        $methodType = $constantArrayType->getValueTypes()[1];
        if (!$methodType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            return \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeAndMethod::createUnknown();
        }
        $objectWithoutClassType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType();
        if ($classOrObjectType instanceof \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantStringType) {
            $value = $classOrObjectType->getValue();
            if (!$this->reflectionProvider->hasClass($value)) {
                return \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeAndMethod::createUnknown();
            }
            $classReflection = $this->reflectionProvider->getClass($value);
            $type = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($classReflection->getName());
        } elseif ($objectWithoutClassType->isSuperTypeOf($classOrObjectType)->yes()) {
            $type = $classOrObjectType;
        } else {
            return \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeAndMethod::createUnknown();
        }
        $trinaryLogic = $type->hasMethod($methodType->getValue());
        if (!$trinaryLogic->no()) {
            return \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeAndMethod::createConcrete($type, $methodType->getValue(), $trinaryLogic);
        }
        return null;
    }
    private function areKeyTypesValid(\_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayType $constantArrayType) : bool
    {
        $keyTypes = $constantArrayType->getKeyTypes();
        if (\count($keyTypes) !== 2) {
            return \false;
        }
        if ($keyTypes[0]->isSuperTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(0))->no()) {
            return \false;
        }
        return !$keyTypes[1]->isSuperTypeOf(new \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantIntegerType(1))->no();
    }
}
