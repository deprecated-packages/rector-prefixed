<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\Mixin;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
class MixinMethodReflection implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
{
    /** @var MethodReflection */
    private $reflection;
    /** @var bool */
    private $static;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $reflection, bool $static)
    {
        $this->reflection = $reflection;
        $this->static = $static;
    }
    public function getDeclaringClass() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
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
    public function getPrototype() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberReflection
    {
        return $this->reflection->getPrototype();
    }
    public function getVariants() : array
    {
        return $this->reflection->getVariants();
    }
    public function isDeprecated() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isFinal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->reflection->isFinal();
    }
    public function isInternal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
    public function getThrowType() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->reflection->getThrowType();
    }
    public function hasSideEffects() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->reflection->hasSideEffects();
    }
}
