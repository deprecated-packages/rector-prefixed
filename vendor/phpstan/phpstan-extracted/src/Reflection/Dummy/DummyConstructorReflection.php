<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\Dummy;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariant;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VoidType;
class DummyConstructorReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
{
    /** @var ClassReflection */
    private $declaringClass;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection $declaringClass)
    {
        $this->declaringClass = $declaringClass;
    }
    public function getDeclaringClass() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function isStatic() : bool
    {
        return \false;
    }
    public function isPrivate() : bool
    {
        return \false;
    }
    public function isPublic() : bool
    {
        return \true;
    }
    public function getName() : string
    {
        return '__construct';
    }
    public function getPrototype() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection
    {
        return $this;
    }
    public function getVariants() : array
    {
        return [new \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariant(\_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [], \false, new \_PhpScopere8e811afab72\PHPStan\Type\VoidType())];
    }
    public function isDeprecated() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isFinal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getThrowType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return null;
    }
    public function hasSideEffects() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createNo();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
