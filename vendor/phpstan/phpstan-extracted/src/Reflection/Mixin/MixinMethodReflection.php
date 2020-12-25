<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Mixin;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class MixinMethodReflection implements \PHPStan\Reflection\MethodReflection
{
    /** @var MethodReflection */
    private $reflection;
    /** @var bool */
    private $static;
    public function __construct(\PHPStan\Reflection\MethodReflection $reflection, bool $static)
    {
        $this->reflection = $reflection;
        $this->static = $static;
    }
    public function getDeclaringClass() : \PHPStan\Reflection\ClassReflection
    {
        return $this->reflection->getDeclaringClass();
    }
    public function isStatic() : bool
    {
        return $this->static;
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
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    public function getPrototype() : \PHPStan\Reflection\ClassMemberReflection
    {
        return $this->reflection->getPrototype();
    }
    public function getVariants() : array
    {
        return $this->reflection->getVariants();
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
