<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

use PHPStan\Reflection\Php\PhpMethodReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Type;
class ResolvedMethodReflection implements \PHPStan\Reflection\MethodReflection
{
    /** @var MethodReflection */
    private $reflection;
    /** @var TemplateTypeMap */
    private $resolvedTemplateTypeMap;
    /** @var \PHPStan\Reflection\ParametersAcceptor[]|null */
    private $variants = null;
    public function __construct(\PHPStan\Reflection\MethodReflection $reflection, \PHPStan\Type\Generic\TemplateTypeMap $resolvedTemplateTypeMap)
    {
        $this->reflection = $reflection;
        $this->resolvedTemplateTypeMap = $resolvedTemplateTypeMap;
    }
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    public function getPrototype() : \PHPStan\Reflection\ClassMemberReflection
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
            $variants[] = new \PHPStan\Reflection\ResolvedFunctionVariant($variant, $this->resolvedTemplateTypeMap);
        }
        $this->variants = $variants;
        return $variants;
    }
    public function getDeclaringClass() : \PHPStan\Reflection\ClassReflection
    {
        return $this->reflection->getDeclaringClass();
    }
    public function getDeclaringTrait() : ?\PHPStan\Reflection\ClassReflection
    {
        if ($this->reflection instanceof \PHPStan\Reflection\Php\PhpMethodReflection) {
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
    public function isDeprecated() : \PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isFinal() : \PHPStan\TrinaryLogic
    {
        return $this->reflection->isFinal();
    }
    public function isInternal() : \PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
    public function getThrowType() : ?\PHPStan\Type\Type
    {
        return $this->reflection->getThrowType();
    }
    public function hasSideEffects() : \PHPStan\TrinaryLogic
    {
        return $this->reflection->hasSideEffects();
    }
}
