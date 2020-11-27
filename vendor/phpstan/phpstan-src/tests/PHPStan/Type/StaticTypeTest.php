<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Broker\Broker;
use PHPStan\TrinaryLogic;
class StaticTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsIterable() : array
    {
        return [[new \PHPStan\Type\StaticType('ArrayObject'), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\StaticType('Traversable'), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\StaticType('Unknown'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\StaticType('DateTime'), \PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataIsIterable
     * @param StaticType $type
     * @param TrinaryLogic $expectedResult
     */
    public function testIsIterable(\PHPStan\Type\StaticType $type, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isIterable();
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isIterable()', $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsCallable() : array
    {
        return [[new \PHPStan\Type\StaticType('Closure'), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\StaticType('Unknown'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\StaticType('DateTime'), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsCallable
     * @param StaticType $type
     * @param TrinaryLogic $expectedResult
     */
    public function testIsCallable(\PHPStan\Type\StaticType $type, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isCallable();
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isCallable()', $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSuperTypeOf() : array
    {
        $broker = $this->createBroker();
        return [0 => [new \PHPStan\Type\StaticType('UnknownClassA'), new \PHPStan\Type\ObjectType('UnknownClassB'), \PHPStan\TrinaryLogic::createMaybe()], 1 => [new \PHPStan\Type\StaticType(\ArrayAccess::class), new \PHPStan\Type\ObjectType(\Traversable::class), \PHPStan\TrinaryLogic::createMaybe()], 2 => [new \PHPStan\Type\StaticType(\Countable::class), new \PHPStan\Type\ObjectType(\Countable::class), \PHPStan\TrinaryLogic::createMaybe()], 3 => [new \PHPStan\Type\StaticType(\DateTimeImmutable::class), new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), \PHPStan\TrinaryLogic::createMaybe()], 4 => [new \PHPStan\Type\StaticType(\Traversable::class), new \PHPStan\Type\ObjectType(\ArrayObject::class), \PHPStan\TrinaryLogic::createMaybe()], 5 => [new \PHPStan\Type\StaticType(\Traversable::class), new \PHPStan\Type\ObjectType(\Iterator::class), \PHPStan\TrinaryLogic::createMaybe()], 6 => [new \PHPStan\Type\StaticType(\ArrayObject::class), new \PHPStan\Type\ObjectType(\Traversable::class), \PHPStan\TrinaryLogic::createMaybe()], 7 => [new \PHPStan\Type\StaticType(\Iterator::class), new \PHPStan\Type\ObjectType(\Traversable::class), \PHPStan\TrinaryLogic::createMaybe()], 8 => [new \PHPStan\Type\StaticType(\ArrayObject::class), new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), \PHPStan\TrinaryLogic::createNo()], 9 => [new \PHPStan\Type\StaticType(\DateTimeImmutable::class), new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createMaybe()], 10 => [new \PHPStan\Type\StaticType(\DateTimeImmutable::class), new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType(\ArrayObject::class), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createNo()], 11 => [new \PHPStan\Type\StaticType(\LogicException::class), new \PHPStan\Type\ObjectType(\InvalidArgumentException::class), \PHPStan\TrinaryLogic::createMaybe()], 12 => [new \PHPStan\Type\StaticType(\InvalidArgumentException::class), new \PHPStan\Type\ObjectType(\LogicException::class), \PHPStan\TrinaryLogic::createMaybe()], 13 => [new \PHPStan\Type\StaticType(\ArrayAccess::class), new \PHPStan\Type\StaticType(\Traversable::class), \PHPStan\TrinaryLogic::createMaybe()], 14 => [new \PHPStan\Type\StaticType(\Countable::class), new \PHPStan\Type\StaticType(\Countable::class), \PHPStan\TrinaryLogic::createYes()], 15 => [new \PHPStan\Type\StaticType(\DateTimeImmutable::class), new \PHPStan\Type\StaticType(\DateTimeImmutable::class), \PHPStan\TrinaryLogic::createYes()], 16 => [new \PHPStan\Type\StaticType(\Traversable::class), new \PHPStan\Type\StaticType(\ArrayObject::class), \PHPStan\TrinaryLogic::createYes()], 17 => [new \PHPStan\Type\StaticType(\Traversable::class), new \PHPStan\Type\StaticType(\Iterator::class), \PHPStan\TrinaryLogic::createYes()], 18 => [new \PHPStan\Type\StaticType(\ArrayObject::class), new \PHPStan\Type\StaticType(\Traversable::class), \PHPStan\TrinaryLogic::createMaybe()], 19 => [new \PHPStan\Type\StaticType(\Iterator::class), new \PHPStan\Type\StaticType(\Traversable::class), \PHPStan\TrinaryLogic::createMaybe()], 20 => [new \PHPStan\Type\StaticType(\ArrayObject::class), new \PHPStan\Type\StaticType(\DateTimeImmutable::class), \PHPStan\TrinaryLogic::createNo()], 21 => [new \PHPStan\Type\StaticType(\DateTimeImmutable::class), new \PHPStan\Type\UnionType([new \PHPStan\Type\StaticType(\DateTimeImmutable::class), new \PHPStan\Type\StaticType(\DateTimeImmutable::class)]), \PHPStan\TrinaryLogic::createYes()], 22 => [new \PHPStan\Type\StaticType(\DateTimeImmutable::class), new \PHPStan\Type\UnionType([new \PHPStan\Type\StaticType(\DateTimeImmutable::class), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createMaybe()], 23 => [new \PHPStan\Type\StaticType(\DateTimeImmutable::class), new \PHPStan\Type\UnionType([new \PHPStan\Type\StaticType(\ArrayObject::class), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createNo()], 24 => [new \PHPStan\Type\StaticType(\LogicException::class), new \PHPStan\Type\StaticType(\InvalidArgumentException::class), \PHPStan\TrinaryLogic::createYes()], 25 => [new \PHPStan\Type\StaticType(\InvalidArgumentException::class), new \PHPStan\Type\StaticType(\LogicException::class), \PHPStan\TrinaryLogic::createMaybe()], 26 => [new \PHPStan\Type\StaticType(\stdClass::class), new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\TrinaryLogic::createMaybe()], 27 => [new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\StaticType(\stdClass::class), \PHPStan\TrinaryLogic::createYes()], 28 => [new \PHPStan\Type\ThisType($broker->getClass(\stdClass::class)), new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\TrinaryLogic::createMaybe()], 29 => [new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\ThisType($broker->getClass(\stdClass::class)), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param Type $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\Type $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataEquals() : array
    {
        $reflectionProvider = \PHPStan\Broker\Broker::getInstance();
        return [[new \PHPStan\Type\ThisType($reflectionProvider->getClass(\Exception::class)), new \PHPStan\Type\ThisType($reflectionProvider->getClass(\Exception::class)), \true], [new \PHPStan\Type\ThisType($reflectionProvider->getClass(\Exception::class)), new \PHPStan\Type\ThisType($reflectionProvider->getClass(\InvalidArgumentException::class)), \false], [new \PHPStan\Type\ThisType($reflectionProvider->getClass(\Exception::class)), new \PHPStan\Type\StaticType(\Exception::class), \false], [new \PHPStan\Type\ThisType($reflectionProvider->getClass(\Exception::class)), new \PHPStan\Type\StaticType(\InvalidArgumentException::class), \false]];
    }
    /**
     * @dataProvider dataEquals
     * @param StaticType $type
     * @param StaticType $otherType
     * @param bool $expected
     */
    public function testEquals(\PHPStan\Type\StaticType $type, \PHPStan\Type\StaticType $otherType, bool $expected) : void
    {
        $this->assertSame($expected, $type->equals($otherType));
        $this->assertSame($expected, $otherType->equals($type));
    }
}
