<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantFloatType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
class FloatTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataAccepts() : array
    {
        return [[new \PHPStan\Type\FloatType(), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType()]), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\NullType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType(), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\ResourceType()]), \PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataAccepts
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $type = new \PHPStan\Type\FloatType();
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataEquals() : array
    {
        return [[new \PHPStan\Type\FloatType(), new \PHPStan\Type\FloatType(), \true], [new \PHPStan\Type\Constant\ConstantFloatType(0.0), new \PHPStan\Type\Constant\ConstantFloatType(0.0), \true], [new \PHPStan\Type\Constant\ConstantFloatType(0.0), new \PHPStan\Type\Constant\ConstantFloatType(1.0), \false], [new \PHPStan\Type\FloatType(), new \PHPStan\Type\Constant\ConstantFloatType(0.0), \false], [new \PHPStan\Type\Constant\ConstantFloatType(0.0), new \PHPStan\Type\FloatType(), \false], [new \PHPStan\Type\FloatType(), new \PHPStan\Type\IntegerType(), \false], [new \PHPStan\Type\Constant\ConstantFloatType(0.0), new \PHPStan\Type\Constant\ConstantIntegerType(0), \false], [new \PHPStan\Type\Constant\ConstantFloatType(0.0), new \PHPStan\Type\Constant\ConstantStringType('0.0'), \false]];
    }
    /**
     * @dataProvider dataEquals
     * @param FloatType $type
     * @param Type $otherType
     * @param bool $expectedResult
     */
    public function testEquals(\PHPStan\Type\FloatType $type, \PHPStan\Type\Type $otherType, bool $expectedResult) : void
    {
        $actualResult = $type->equals($otherType);
        $this->assertSame($expectedResult, $actualResult, \sprintf('%s->equals(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
}
