<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Dummy;

use PHPStan\Broker\Broker;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\PropertyReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
class DummyPropertyReflection implements \PHPStan\Reflection\PropertyReflection
{
    public function getDeclaringClass() : \PHPStan\Reflection\ClassReflection
    {
        $broker = \PHPStan\Broker\Broker::getInstance();
        return $broker->getClass(\stdClass::class);
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
        return new \PHPStan\Type\MixedType();
    }
    public function getWritableType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\MixedType();
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
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
