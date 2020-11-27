<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
class ObjectWithoutClassTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\ObjectType('Exception'), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType('Exception')), new \PHPStan\Type\ObjectType('Exception'), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType(\InvalidArgumentException::class)), new \PHPStan\Type\ObjectType('Exception'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType('Exception')), new \PHPStan\Type\ObjectType(\InvalidArgumentException::class), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType('Exception')), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType('Exception')), new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType(\InvalidArgumentException::class)), new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType('Exception')), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType('Exception')), new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType(\InvalidArgumentException::class)), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param ObjectWithoutClassType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\ObjectWithoutClassType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
}
