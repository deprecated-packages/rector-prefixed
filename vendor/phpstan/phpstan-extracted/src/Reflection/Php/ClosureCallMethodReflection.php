<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Php;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariant;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeParameterReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\ClosureType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
final class ClosureCallMethodReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
{
    /** @var MethodReflection */
    private $nativeMethodReflection;
    /** @var ClosureType */
    private $closureType;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $nativeMethodReflection, \_PhpScopere8e811afab72\PHPStan\Type\ClosureType $closureType)
    {
        $this->nativeMethodReflection = $nativeMethodReflection;
        $this->closureType = $closureType;
    }
    public function getDeclaringClass() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        return $this->nativeMethodReflection->getDeclaringClass();
    }
    public function isStatic() : bool
    {
        return $this->nativeMethodReflection->isStatic();
    }
    public function isPrivate() : bool
    {
        return $this->nativeMethodReflection->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->nativeMethodReflection->isPublic();
    }
    public function getDocComment() : ?string
    {
        return $this->nativeMethodReflection->getDocComment();
    }
    public function getName() : string
    {
        return $this->nativeMethodReflection->getName();
    }
    public function getPrototype() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection
    {
        return $this->nativeMethodReflection->getPrototype();
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        $parameters = $this->closureType->getParameters();
        $newThis = new \_PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeParameterReflection('newThis', \false, new \_PhpScopere8e811afab72\PHPStan\Type\ObjectWithoutClassType(), \_PhpScopere8e811afab72\PHPStan\Reflection\PassedByReference::createNo(), \false, null);
        \array_unshift($parameters, $newThis);
        return [new \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariant($this->closureType->getTemplateTypeMap(), $this->closureType->getResolvedTemplateTypeMap(), $parameters, $this->closureType->isVariadic(), $this->closureType->getReturnType())];
    }
    public function isDeprecated() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->nativeMethodReflection->getDeprecatedDescription();
    }
    public function isFinal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->isFinal();
    }
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->isInternal();
    }
    public function getThrowType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->nativeMethodReflection->getThrowType();
    }
    public function hasSideEffects() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->hasSideEffects();
    }
}
