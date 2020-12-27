<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Native;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodPrototypeReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\Php\BuiltinMethodReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class NativeMethodReflection implements \PHPStan\Reflection\MethodReflection
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /** @var BuiltinMethodReflection */
    private $reflection;
    /** @var \PHPStan\Reflection\ParametersAcceptorWithPhpDocs[] */
    private $variants;
    /** @var TrinaryLogic */
    private $hasSideEffects;
    /** @var string|null */
    private $stubPhpDocString;
    /**
     * @param \PHPStan\Reflection\ReflectionProvider $reflectionProvider
     * @param \PHPStan\Reflection\ClassReflection $declaringClass
     * @param BuiltinMethodReflection $reflection
     * @param \PHPStan\Reflection\ParametersAcceptorWithPhpDocs[] $variants
     * @param TrinaryLogic $hasSideEffects
     * @param string|null $stubPhpDocString
     */
    public function __construct(\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \PHPStan\Reflection\ClassReflection $declaringClass, \PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, array $variants, \PHPStan\TrinaryLogic $hasSideEffects, ?string $stubPhpDocString)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->declaringClass = $declaringClass;
        $this->reflection = $reflection;
        $this->variants = $variants;
        $this->hasSideEffects = $hasSideEffects;
        $this->stubPhpDocString = $stubPhpDocString;
    }
    public function getDeclaringClass() : \PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
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
    public function isAbstract() : bool
    {
        return $this->reflection->isAbstract();
    }
    public function getPrototype() : \PHPStan\Reflection\ClassMemberReflection
    {
        try {
            $prototypeMethod = $this->reflection->getPrototype();
            $prototypeDeclaringClass = $this->reflectionProvider->getClass($prototypeMethod->getDeclaringClass()->getName());
            return new \PHPStan\Reflection\MethodPrototypeReflection($prototypeMethod->getName(), $prototypeDeclaringClass, $prototypeMethod->isStatic(), $prototypeMethod->isPrivate(), $prototypeMethod->isPublic(), $prototypeMethod->isAbstract(), $prototypeMethod->isFinal(), $prototypeDeclaringClass->getNativeMethod($prototypeMethod->getName())->getVariants());
        } catch (\ReflectionException $e) {
            return $this;
        }
    }
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptorWithPhpDocs[]
     */
    public function getVariants() : array
    {
        return $this->variants;
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isDeprecated() : \PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function isInternal() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function isFinal() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createFromBoolean($this->reflection->isFinal());
    }
    public function getThrowType() : ?\PHPStan\Type\Type
    {
        return null;
    }
    public function hasSideEffects() : \PHPStan\TrinaryLogic
    {
        return $this->hasSideEffects;
    }
    public function getDocComment() : ?string
    {
        if ($this->stubPhpDocString !== null) {
            return $this->stubPhpDocString;
        }
        return $this->reflection->getDocComment();
    }
}
