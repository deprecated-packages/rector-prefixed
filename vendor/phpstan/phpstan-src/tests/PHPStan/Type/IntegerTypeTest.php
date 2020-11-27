<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantFloatType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
class IntegerTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataAccepts() : array
    {
        return [[new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\Constant\ConstantIntegerType(1), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\NullType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataAccepts
     * @param IntegerType  $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\IntegerType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSuperTypeOf() : iterable
    {
        (yield [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\Constant\ConstantIntegerType(1), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param IntegerType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\IntegerType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataEquals() : array
    {
        return [[new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType(), \true], [new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(0), \true], [new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1), \false], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\Constant\ConstantIntegerType(0), \false], [new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\IntegerType(), \false], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType(), \false], [new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantFloatType(0.0), \false], [new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantStringType('0'), \false]];
    }
    /**
     * @dataProvider dataEquals
     * @param IntegerType $type
     * @param Type $otherType
     * @param bool $expectedResult
     */
    public function testEquals(\PHPStan\Type\IntegerType $type, \PHPStan\Type\Type $otherType, bool $expectedResult) : void
    {
        $actualResult = $type->equals($otherType);
        $this->assertSame($expectedResult, $actualResult, \sprintf('%s->equals(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
}
