<?php

declare (strict_types=1);
namespace PHPStan\Type\Accessory;

use RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer;
use RectorPrefix20201227\PHPStan\Reflection\Dummy\DummyMethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\MethodReflection;
use RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor;
use RectorPrefix20201227\PHPStan\TrinaryLogic;
use PHPStan\Type\CompoundType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\Traits\NonGenericTypeTrait;
use PHPStan\Type\Traits\ObjectTypeTrait;
use PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
class HasMethodType implements \PHPStan\Type\Accessory\AccessoryType, \PHPStan\Type\CompoundType
{
    use ObjectTypeTrait;
    use NonGenericTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    /** @var string */
    private $methodName;
    public function __construct(string $methodName)
    {
        $this->methodName = $methodName;
    }
    public function getReferencedClasses() : array
    {
        return [];
    }
    private function getCanonicalMethodName() : string
    {
        return \strtolower($this->methodName);
    }
    public function accepts(\PHPStan\Type\Type $type, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createFromBoolean($this->equals($type));
    }
    public function isSuperTypeOf(\PHPStan\Type\Type $type) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $type->hasMethod($this->methodName);
    }
    public function isSubTypeOf(\PHPStan\Type\Type $otherType) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($otherType instanceof \PHPStan\Type\UnionType || $otherType instanceof \PHPStan\Type\IntersectionType) {
            return $otherType->isSuperTypeOf($this);
        }
        if ($otherType instanceof self) {
            $limit = \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        } else {
            $limit = \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
        }
        return $limit->and($otherType->hasMethod($this->methodName));
    }
    public function isAcceptedBy(\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        return $this->isSubTypeOf($acceptingType);
    }
    public function equals(\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof self && $this->getCanonicalMethodName() === $type->getCanonicalMethodName();
    }
    public function describe(\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('hasMethod(%s)', $this->methodName);
    }
    public function hasMethod(string $methodName) : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($this->getCanonicalMethodName() === \strtolower($methodName)) {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getMethod(string $methodName, \RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \RectorPrefix20201227\PHPStan\Reflection\MethodReflection
    {
        return new \RectorPrefix20201227\PHPStan\Reflection\Dummy\DummyMethodReflection($this->methodName);
    }
    public function isCallable() : \RectorPrefix20201227\PHPStan\TrinaryLogic
    {
        if ($this->getCanonicalMethodName() === '__invoke') {
            return \RectorPrefix20201227\PHPStan\TrinaryLogic::createYes();
        }
        return \RectorPrefix20201227\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getCallableParametersAcceptors(\RectorPrefix20201227\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return [new \RectorPrefix20201227\PHPStan\Reflection\TrivialParametersAcceptor()];
    }
    public function traverse(callable $cb) : \PHPStan\Type\Type
    {
        return $this;
    }
    public static function __set_state(array $properties) : \PHPStan\Type\Type
    {
        return new self($properties['methodName']);
    }
}
