<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Php;

use PHPStan\Reflection\ClassReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class UniversalObjectCrateProperty implements \PHPStan\Reflection\PropertyReflection
{
    /** @var \PHPStan\Reflection\ClassReflection */
    private $declaringClass;
    /** @var \PHPStan\Type\Type */
    private $readableType;
    /** @var \PHPStan\Type\Type */
    private $writableType;
    public function __construct(\PHPStan\Reflection\ClassReflection $declaringClass, \PHPStan\Type\Type $readableType, \PHPStan\Type\Type $writableType)
    {
        $this->declaringClass = $declaringClass;
        $this->readableType = $readableType;
        $this->writableType = $writableType;
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
    public function getReadableType() : \PHPStan\Type\Type
    {
        return $this->readableType;
    }
    public function getWritableType() : \PHPStan\Type\Type
    {
        return $this->writableType;
    }
    public function canChangeTypeAfterAssignment() : bool
    {
        return \true;
    }
    public function isReadable() : bool
    {
        return \true;
    }
    public function isWritable() : bool
    {
        return \true;
    }
    public function isDeprecated() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
