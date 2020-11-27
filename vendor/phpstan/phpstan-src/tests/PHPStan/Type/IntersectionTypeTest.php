<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Accessory\HasOffsetType;
use PHPStan\Type\Accessory\HasPropertyType;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use _PhpScoper006a73f0e455\Test\ClassWithToString;
class IntersectionTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataAccepts() : \Iterator
    {
        $intersectionType = new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType('Collection'), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item'))]);
        (yield [$intersectionType, $intersectionType, \PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionType, new \PHPStan\Type\ObjectType('Collection'), \PHPStan\TrinaryLogic::createNo()]);
        (yield [$intersectionType, new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item')), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\_PhpScoper006a73f0e455\Test\ClassWithToString::class), new \PHPStan\Type\Accessory\HasPropertyType('foo')]), new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createNo()]);
        (yield [\PHPStan\Type\TypeCombinator::intersect(new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\CallableType()), new \PHPStan\Type\CallableType(), \PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataAccepts
     * @param IntersectionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\IntersectionType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsCallable() : array
    {
        return [[new \PHPStan\Type\IntersectionType([new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantStringType('Closure'), new \PHPStan\Type\Constant\ConstantStringType('bind')]), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item'))]), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item'))]), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType('ArrayObject'), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item'))]), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsCallable
     * @param IntersectionType $type
     * @param TrinaryLogic $expectedResult
     */
    public function testIsCallable(\PHPStan\Type\IntersectionType $type, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isCallable();
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isCallable()', $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSuperTypeOf() : \Iterator
    {
        $intersectionTypeA = new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType('ArrayObject'), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item'))]);
        (yield [$intersectionTypeA, $intersectionTypeA, \PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeA, new \PHPStan\Type\ObjectType('ArrayObject'), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$intersectionTypeA, new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item')), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$intersectionTypeA, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item')), \PHPStan\TrinaryLogic::createNo()]);
        $intersectionTypeB = new \PHPStan\Type\IntersectionType([new \PHPStan\Type\IntegerType()]);
        (yield [$intersectionTypeB, $intersectionTypeB, \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\Accessory\HasOffsetType(new \PHPStan\Type\StringType())]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b'), new \PHPStan\Type\Constant\ConstantStringType('c')], [new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(2), new \PHPStan\Type\Constant\ConstantIntegerType(3)]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\Accessory\HasOffsetType(new \PHPStan\Type\StringType())]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b'), new \PHPStan\Type\Constant\ConstantStringType('c'), new \PHPStan\Type\Constant\ConstantStringType('d'), new \PHPStan\Type\Constant\ConstantStringType('e'), new \PHPStan\Type\Constant\ConstantStringType('f'), new \PHPStan\Type\Constant\ConstantStringType('g'), new \PHPStan\Type\Constant\ConstantStringType('h'), new \PHPStan\Type\Constant\ConstantStringType('i')], [new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(2), new \PHPStan\Type\Constant\ConstantIntegerType(3), new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(2), new \PHPStan\Type\Constant\ConstantIntegerType(3), new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(2), new \PHPStan\Type\Constant\ConstantIntegerType(3)]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\Traversable::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\ObjectType(\stdClass::class))]), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\Traversable::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\ObjectType(\stdClass::class))]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\_PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\ObjectType(\stdClass::class))]), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\_PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\ObjectType(\stdClass::class))]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\_PhpScoper006a73f0e455\TestIntersectionTypeIsSupertypeOf\Collection::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\ObjectType(\stdClass::class))]), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\_PhpScoper006a73f0e455\TestIntersectionTypeIsSupertypeOf\Collection::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\ObjectType(\stdClass::class))]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\_PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\ObjectType(\stdClass::class))]), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\_PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType(\stdClass::class))]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\_PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType(\stdClass::class))]), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\_PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\ObjectType(\stdClass::class))]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\_PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType(\stdClass::class))]), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\_PhpScoper006a73f0e455\DoctrineIntersectionTypeIsSupertypeOf\Collection::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType(\stdClass::class))]), \PHPStan\TrinaryLogic::createYes()]);
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param IntersectionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\IntersectionType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSubTypeOf() : \Iterator
    {
        $intersectionTypeA = new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType('ArrayObject'), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item'))]);
        (yield [$intersectionTypeA, $intersectionTypeA, \PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeA, new \PHPStan\Type\ObjectType('ArrayObject'), \PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeA, new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item')), \PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeA, new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeA, new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Unknown')), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$intersectionTypeA, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item')), \PHPStan\TrinaryLogic::createNo()]);
        $intersectionTypeB = new \PHPStan\Type\IntersectionType([new \PHPStan\Type\IntegerType()]);
        (yield [$intersectionTypeB, $intersectionTypeB, \PHPStan\TrinaryLogic::createYes()]);
        $intersectionTypeC = new \PHPStan\Type\IntersectionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\CallableType()]);
        (yield [$intersectionTypeC, $intersectionTypeC, \PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeC, new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeC, new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createYes()]);
        $intersectionTypeD = new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType('ArrayObject'), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('DatePeriod'))]);
        (yield [$intersectionTypeD, $intersectionTypeD, \PHPStan\TrinaryLogic::createYes()]);
        (yield [$intersectionTypeD, new \PHPStan\Type\UnionType([$intersectionTypeD, new \PHPStan\Type\IntegerType()]), \PHPStan\TrinaryLogic::createYes()]);
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param IntersectionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOf(\PHPStan\Type\IntersectionType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSubTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSubTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param IntersectionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOfInversed(\PHPStan\Type\IntersectionType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $otherType->isSuperTypeOf($type);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $otherType->describe(\PHPStan\Type\VerbosityLevel::precise()), $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function testToBooleanCrash() : void
    {
        $type = new \PHPStan\Type\IntersectionType([new \PHPStan\Type\NeverType(), new \PHPStan\Type\Accessory\NonEmptyArrayType()]);
        $this->assertSame('bool', $type->toBoolean()->describe(\PHPStan\Type\VerbosityLevel::precise()));
    }
}
