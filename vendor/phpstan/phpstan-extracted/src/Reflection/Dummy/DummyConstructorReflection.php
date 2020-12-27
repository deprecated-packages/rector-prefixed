<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Dummy;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\Type;
use PHPStan\Type\VoidType;
class DummyConstructorReflection implements \PHPStan\Reflection\MethodReflection
{
    /** @var ClassReflection */
    private $declaringClass;
    public function __construct(\PHPStan\Reflection\ClassReflection $declaringClass)
    {
        $this->declaringClass = $declaringClass;
    }
    public function getDeclaringClass() : \PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function isStatic() : bool
    {
        return \false;
    }
    public function isPrivate() : bool
    {
        return \false;
    }
    public function isPublic() : bool
    {
        return \true;
    }
    public function getName() : string
    {
        return '__construct';
    }
    public function getPrototype() : \PHPStan\Reflection\ClassMemberReflection
    {
        return $this;
    }
    public function getVariants() : array
    {
        return [new \PHPStan\Reflection\FunctionVariant(\PHPStan\Type\Generic\TemplateTypeMap::createEmpty(), null, [], \false, new \PHPStan\Type\VoidType())];
    }
    public function isDeprecated() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isFinal() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function isInternal() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getThrowType() : ?\PHPStan\Type\Type
    {
        return null;
    }
    public function hasSideEffects() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
