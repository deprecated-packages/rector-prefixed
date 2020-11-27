<?php

declare (strict_types=1);
namespace PHPStan\Type\Accessory;

use PHPStan\TrinaryLogic;
use PHPStan\Type\CallableType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
class HasPropertyTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \PHPStan\Type\Accessory\HasPropertyType('format'), new \PHPStan\Type\Accessory\HasPropertyType('format'), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\Accessory\HasPropertyType('format'), new \PHPStan\Type\Accessory\HasPropertyType('FORMAT'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Accessory\HasPropertyType('d'), new \PHPStan\Type\ObjectType(\DateInterval::class), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\Accessory\HasPropertyType('foo'), new \PHPStan\Type\ObjectType('UnknownClass'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Accessory\HasPropertyType('foo'), new \PHPStan\Type\ObjectType(\Closure::class), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\Accessory\HasPropertyType('foo'), new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Accessory\HasPropertyType('foo'), new \PHPStan\Type\Accessory\HasPropertyType('bar'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Accessory\HasPropertyType('foo'), new \PHPStan\Type\Accessory\HasOffsetType(new \PHPStan\Type\MixedType()), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Accessory\HasPropertyType('foo'), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Accessory\HasPropertyType('foo'), new \PHPStan\Type\CallableType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Accessory\HasPropertyType('d'), new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Accessory\HasPropertyType('d'), new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType(\DateInterval::class), new \PHPStan\Type\ObjectType('UnknownClass')]), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Accessory\HasPropertyType('d'), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType('UnknownClass'), new \PHPStan\Type\Accessory\HasPropertyType('d')]), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\Accessory\HasPropertyType('d'), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\Accessory\HasPropertyType('d')]), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param HasPropertyType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\Accessory\HasPropertyType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSubTypeOf() : array
    {
        return [[new \PHPStan\Type\Accessory\HasPropertyType('foo'), new \PHPStan\Type\Accessory\HasPropertyType('foo'), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\Accessory\HasPropertyType('foo'), new \PHPStan\Type\UnionType([new \PHPStan\Type\Accessory\HasPropertyType('foo'), new \PHPStan\Type\NullType()]), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\Accessory\HasPropertyType('foo'), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\Accessory\HasPropertyType('foo'), new \PHPStan\Type\Accessory\HasPropertyType('bar')]), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Accessory\HasPropertyType('d'), new \PHPStan\Type\ObjectType(\DateInterval::class), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param HasPropertyType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOf(\PHPStan\Type\Accessory\HasPropertyType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSubTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSubTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param HasPropertyType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOfInversed(\PHPStan\Type\Accessory\HasPropertyType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $otherType->isSuperTypeOf($type);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $otherType->describe(\PHPStan\Type\VerbosityLevel::precise()), $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
}
