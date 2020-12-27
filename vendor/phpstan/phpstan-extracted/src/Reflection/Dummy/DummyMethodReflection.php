<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Dummy;

use PHPStan\Broker\Broker;
use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\TrivialParametersAcceptor;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class DummyMethodReflection implements \PHPStan\Reflection\MethodReflection
{
    /** @var string */
    private $name;
    public function __construct(string $name)
    {
        $this->name = $name;
    }
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
    public function getName() : string
    {
        return $this->name;
    }
    public function getPrototype() : \PHPStan\Reflection\ClassMemberReflection
    {
        return $this;
    }
    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants() : array
    {
        return [new \PHPStan\Reflection\TrivialParametersAcceptor()];
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
        return \PHPStan\TrinaryLogic::createMaybe();
    }
    public function getDocComment() : ?string
    {
        return null;
    }
}
