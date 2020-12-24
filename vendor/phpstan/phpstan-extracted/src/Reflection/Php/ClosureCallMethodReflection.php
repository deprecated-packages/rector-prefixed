<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\Php;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionVariant;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\Native\NativeParameterReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference;
use _PhpScoperb75b35f52b74\PHPStan\TrinaryLogic;
use _PhpScoperb75b35f52b74\PHPStan\Type\ClosureType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
final class ClosureCallMethodReflection implements \_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection
{
    /** @var MethodReflection */
    private $nativeMethodReflection;
    /** @var ClosureType */
    private $closureType;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection $nativeMethodReflection, \_PhpScoperb75b35f52b74\PHPStan\Type\ClosureType $closureType)
    {
        $this->nativeMethodReflection = $nativeMethodReflection;
        $this->closureType = $closureType;
    }
    public function getDeclaringClass() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassReflection
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
    public function getPrototype() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberReflection
    {
        return $this->nativeMethodReflection->getPrototype();
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        $parameters = $this->closureType->getParameters();
        $newThis = new \_PhpScoperb75b35f52b74\PHPStan\Reflection\Native\NativeParameterReflection('newThis', \false, new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectWithoutClassType(), \_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference::createNo(), \false, null);
        \array_unshift($parameters, $newThis);
        return [new \_PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionVariant($this->closureType->getTemplateTypeMap(), $this->closureType->getResolvedTemplateTypeMap(), $parameters, $this->closureType->isVariadic(), $this->closureType->getReturnType())];
    }
    public function isDeprecated() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->nativeMethodReflection->getDeprecatedDescription();
    }
    public function isFinal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->isFinal();
    }
    public function isInternal() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->isInternal();
    }
    public function getThrowType() : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        return $this->nativeMethodReflection->getThrowType();
    }
    public function hasSideEffects() : \_PhpScoperb75b35f52b74\PHPStan\TrinaryLogic
    {
        return $this->nativeMethodReflection->hasSideEffects();
    }
}
