<?php

declare (strict_types=1);
namespace PHPStan\Type\Constant;

use PHPStan\TrinaryLogic;
use PHPStan\Type\IntegerType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
class ConstantIntegerTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataAccepts() : iterable
    {
        (yield [new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(1), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(2), \PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataAccepts
     * @param ConstantIntegerType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\Constant\ConstantIntegerType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSuperTypeOf() : iterable
    {
        (yield [new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(1), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(2), \PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param ConstantIntegerType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\Constant\ConstantIntegerType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
}
