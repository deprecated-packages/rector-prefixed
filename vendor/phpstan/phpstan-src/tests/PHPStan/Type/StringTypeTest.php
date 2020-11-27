<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Testing\TestCase;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Accessory\HasPropertyType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Generic\GenericClassStringType;
use _PhpScoper26e51eeacccf\Test\ClassWithToString;
class StringTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \PHPStan\Type\StringType(), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     */
    public function testIsSuperTypeOf(\PHPStan\Type\StringType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataAccepts() : iterable
    {
        (yield [new \PHPStan\Type\StringType(), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\_PhpScoper26e51eeacccf\Test\ClassWithToString::class), new \PHPStan\Type\Accessory\HasPropertyType('foo')]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\StringType(), new \PHPStan\Type\ClassStringType(), \PHPStan\TrinaryLogic::createYes()]);
    }
    /**
     * @dataProvider dataAccepts
     * @param \PHPStan\Type\StringType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\StringType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataEquals() : array
    {
        return [[new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType(), \true], [new \PHPStan\Type\Constant\ConstantStringType('foo'), new \PHPStan\Type\Constant\ConstantStringType('foo'), \true], [new \PHPStan\Type\Constant\ConstantStringType('foo'), new \PHPStan\Type\Constant\ConstantStringType('bar'), \false], [new \PHPStan\Type\StringType(), new \PHPStan\Type\Constant\ConstantStringType(''), \false], [new \PHPStan\Type\Constant\ConstantStringType(''), new \PHPStan\Type\StringType(), \false], [new \PHPStan\Type\StringType(), new \PHPStan\Type\ClassStringType(), \false]];
    }
    /**
     * @dataProvider dataEquals
     * @param StringType $type
     * @param Type $otherType
     * @param bool $expectedResult
     */
    public function testEquals(\PHPStan\Type\StringType $type, \PHPStan\Type\Type $otherType, bool $expectedResult) : void
    {
        $actualResult = $type->equals($otherType);
        $this->assertSame($expectedResult, $actualResult, \sprintf('%s->equals(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
}
