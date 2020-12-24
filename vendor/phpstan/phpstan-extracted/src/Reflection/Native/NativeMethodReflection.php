<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Native;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodPrototypeReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\BuiltinMethodReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class NativeMethodReflection implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodReflection
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection $declaringClass, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\BuiltinMethodReflection $reflection, array $variants, \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic $hasSideEffects, ?string $stubPhpDocString)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->declaringClass = $declaringClass;
        $this->reflection = $reflection;
        $this->variants = $variants;
        $this->hasSideEffects = $hasSideEffects;
        $this->stubPhpDocString = $stubPhpDocString;
    }
    public function getDeclaringClass() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection
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
    public function getPrototype() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberReflection
    {
        try {
            $prototypeMethod = $this->reflection->getPrototype();
            $prototypeDeclaringClass = $this->reflectionProvider->getClass($prototypeMethod->getDeclaringClass()->getName());
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\MethodPrototypeReflection($prototypeMethod->getName(), $prototypeDeclaringClass, $prototypeMethod->isStatic(), $prototypeMethod->isPrivate(), $prototypeMethod->isPublic(), $prototypeMethod->isAbstract(), $prototypeMethod->isFinal(), $prototypeDeclaringClass->getNativeMethod($prototypeMethod->getName())->getVariants());
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
    public function isDeprecated() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function isInternal() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createNo();
    }
    public function isFinal() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createFromBoolean($this->reflection->isFinal());
    }
    public function getThrowType() : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return null;
    }
    public function hasSideEffects() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
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
