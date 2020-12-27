<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\Dummy;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\ConstantReflection;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
class DummyConstantReflection implements \RectorPrefix20201227\PHPStan\Reflection\ConstantReflection
{
    /** @var string */
    private $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    public function getDeclaringClass() : \RectorPrefix20201227\PHPStan\Reflection\ClassReflection
    {
        $broker = \RectorPrefix20201227\PHPStan\Broker\Broker::getInstance();
        return $broker->getClass(\stdClass::class);
    }
    public function getFileName() : ?string
    {
        return null;
    }
    public function isStatic() : bool
    {
        return \true;
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
        return $this->name;
    }
    /**
     * @return mixed
     */
    public function getValue()
    {
        // so that Scope::getTypeFromValue() returns mixed
        return new \stdClass();
    }
    public function getValueType() : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\MixedType();
    }
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
