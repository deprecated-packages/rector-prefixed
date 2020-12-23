<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\Php;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionVariant;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Native\NativeParameterReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PassedByReference;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ClosureType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
final class ClosureCallMethodReflection implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection
{
    /** @var MethodReflection */
    private $nativeMethodReflection;
    /** @var ClosureType */
    private $closureType;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection $nativeMethodReflection, \_PhpScoper0a2ac50786fa\PHPStan\Type\ClosureType $closureType)
    {
        $this->nativeMethodReflection = $nativeMethodReflection;
        $this->closureType = $closureType;
    }
    public function getDeclaringClass() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
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
    public function getPrototype() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberReflection
    {
        return $this->nativeMethodReflection->getPrototype();
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        $parameters = $this->closureType->getParameters();
        $newThis = new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Native\NativeParameterReflection('newThis', \false, new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectWithoutClassType(), \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PassedByReference::createNo(), \false, null);
        \array_unshift($parameters, $newThis);
        return [new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionVariant($this->closureType->getTemplateTypeMap(), $this->closureType->getResolvedTemplateTypeMap(), $parameters, $this->closureType->isVariadic(), $this->closureType->getReturnType())];
    }
    public function isDeprecated() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->nativeMethodReflection->getDeprecatedDescription();
    }
    public function isFinal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->isFinal();
    }
    public function isInternal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->isInternal();
    }
    public function getThrowType() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return $this->nativeMethodReflection->getThrowType();
    }
    public function hasSideEffects() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->hasSideEffects();
    }
}
