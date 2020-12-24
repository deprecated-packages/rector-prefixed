<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Dummy;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class DummyPropertyReflection implements \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\PropertyReflection
{
    public function getDeclaringClass() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassReflection
    {
        $broker = \_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\Broker::getInstance();
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
    public function getReadableType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
    }
    public function getWritableType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
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
    public function isDeprecated() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic
    {
        return \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
