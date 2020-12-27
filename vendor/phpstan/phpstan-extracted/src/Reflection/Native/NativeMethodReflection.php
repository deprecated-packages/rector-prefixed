<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\Native;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodPrototypeReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\Php\BuiltinMethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class NativeMethodReflection implements \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
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
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \RectorPrefix20201227\PHPStan\Reflection\ClassReflection $declaringClass, \RectorPrefix20201227\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, array $variants, \RectorPrefix20201227\PHPStan\TrinaryLogic $hasSideEffects, ?string $stubPhpDocString)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->declaringClass = $declaringClass;
        $this->reflection = $reflection;
        $this->variants = $variants;
        $this->hasSideEffects = $hasSideEffects;
        $this->stubPhpDocString = $stubPhpDocString;
    }
    public function getDeclaringClass() : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection
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
    public function getPrototype() : \RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection
    {
        try {
            $prototypeMethod = $this->reflection->getPrototype();
            $prototypeDeclaringClass = $this->reflectionProvider->getClass($prototypeMethod->getDeclaringClass()->getName());
            return new \RectorPrefix20201227\PHPStan\Reflection\MethodPrototypeReflection($prototypeMethod->getName(), $prototypeDeclaringClass, $prototypeMethod->isStatic(), $prototypeMethod->isPrivate(), $prototypeMethod->isPublic(), $prototypeMethod->isAbstract(), $prototypeMethod->isFinal(), $prototypeDeclaringClass->getNativeMethod($prototypeMethod->getName())->getVariants());
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
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createNo();
    }
    public function isFinal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($this->reflection->isFinal());
    }
    public function getThrowType() : ?\PHPStan\Type\Type
    {
        return null;
    }
    public function hasSideEffects() : \RectorPrefix20201227\PHPStan\TrinaryLogic
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
