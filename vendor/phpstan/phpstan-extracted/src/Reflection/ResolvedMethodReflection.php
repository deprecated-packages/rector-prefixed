<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection;

use _PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpMethodReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class ResolvedMethodReflection implements \_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection
{
    /** @var MethodReflection */
    private $reflection;
    /** @var TemplateTypeMap */
    private $resolvedTemplateTypeMap;
    /** @var \PHPStan\Reflection\ParametersAcceptor[]|null */
    private $variants = null;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection $reflection, \_PhpScopere8e811afab72\PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap)
    {
        $this->reflection = $reflection;
        $this->resolvedTemplateTypeMap = $resolvedTemplateTypeMap;
    }
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    public function getPrototype() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberReflection
    {
        return $this->reflection->getPrototype();
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        $variants = $this->variants;
        if ($variants !== null) {
            return $variants;
        }
        $variants = [];
        foreach ($this->reflection->getVariants() as $variant) {
            $variants[] = new \_PhpScopere8e811afab72\PHPStan\Reflection\ResolvedFunctionVariant($variant, $this->resolvedTemplateTypeMap);
        }
        $this->variants = $variants;
        return $variants;
    }
    public function getDeclaringClass() : \_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        return $this->reflection->getDeclaringClass();
    }
    public function getDeclaringTrait() : ?\_PhpScopere8e811afab72\PHPStan\Reflection\ClassReflection
    {
        if ($this->reflection instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpMethodReflection) {
            return $this->reflection->getDeclaringTrait();
        }
        return null;
    }
    public function isStatic() : bool
    {
        return $this->reflection->isStatic();
    }
    public function isPrivate() : bool
    {
        return $this->reflection->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->reflection->isPublic();
    }
    public function getDocComment() : ?string
    {
        return $this->reflection->getDocComment();
    }
    public function isDeprecated() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isFinal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->reflection->isFinal();
    }
    public function isInternal() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
    public function getThrowType() : ?\_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        return $this->reflection->getThrowType();
    }
    public function hasSideEffects() : \_PhpScopere8e811afab72\PHPStan\TrinaryLogic
    {
        return $this->reflection->hasSideEffects();
    }
}
