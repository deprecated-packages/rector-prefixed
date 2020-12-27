<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\Php;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\FunctionVariant;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\Native\NativeParameterReflection;
use RectorPrefix20201227\PHPStan\Reflection\PassedByReference;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\ClosureType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\Type;
final class ClosureCallMethodReflection implements \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
{
    /** @var MethodReflection */
    private $nativeMethodReflection;
    /** @var ClosureType */
    private $closureType;
    public function __construct(\RectorPrefix20201227\PHPStan\Reflection\MethodReflection $nativeMethodReflection, \PHPStan\Type\ClosureType $closureType)
    {
        $this->nativeMethodReflection = $nativeMethodReflection;
        $this->closureType = $closureType;
    }
    public function getDeclaringClass() : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection
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
    public function getPrototype() : \RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection
    {
        return $this->nativeMethodReflection->getPrototype();
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        $parameters = $this->closureType->getParameters();
        $newThis = new \RectorPrefix20201227\PHPStan\Reflection\Native\NativeParameterReflection('newThis', \false, new \PHPStan\Type\ObjectWithoutClassType(), \RectorPrefix20201227\PHPStan\Reflection\PassedByReference::createNo(), \false, null);
        \array_unshift($parameters, $newThis);
        return [new \RectorPrefix20201227\PHPStan\Reflection\FunctionVariant($this->closureType->getTemplateTypeMap(), $this->closureType->getResolvedTemplateTypeMap(), $parameters, $this->closureType->isVariadic(), $this->closureType->getReturnType())];
    }
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->nativeMethodReflection->getDeprecatedDescription();
    }
    public function isFinal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->isFinal();
    }
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->isInternal();
    }
    public function getThrowType() : ?\PHPStan\Type\Type
    {
        return $this->nativeMethodReflection->getThrowType();
    }
    public function hasSideEffects() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->hasSideEffects();
    }
}
