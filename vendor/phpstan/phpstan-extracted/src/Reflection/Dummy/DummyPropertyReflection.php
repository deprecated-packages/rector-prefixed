<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\Dummy;

use _PhpScoper0a2ac50786fa\PHPStan\Broker\Broker;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
class DummyPropertyReflection implements \_PhpScoper0a2ac50786fa\PHPStan\Reflection\PropertyReflection
{
    public function getDeclaringClass() : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassReflection
    {
        $broker = \_PhpScoper0a2ac50786fa\PHPStan\Broker\Broker::getInstance();
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
    public function getReadableType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
    public function getWritableType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
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
    public function isDeprecated() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic
    {
        return \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
