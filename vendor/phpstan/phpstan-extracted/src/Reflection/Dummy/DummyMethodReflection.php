<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\Dummy;

use RectorPrefix20201227\PHPStan\Broker\Broker;
use RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection;
use RectorPrefix20201227\PHPStan\Reflection\ClassReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class DummyMethodReflection implements \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
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
        return $this->name;
    }
    public function getPrototype() : \RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection
    {
        return $this;
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        return [new \RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function isDeprecated() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isFinal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function isInternal() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getThrowType() : ?\PHPStan\Type\Type
    {
        return null;
    }
    public function hasSideEffects() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
