<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
class BooleanTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataAccepts() : array
    {
        return [[new \PHPStan\Type\BooleanType(), new \PHPStan\Type\BooleanType(), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\BooleanType(), new \PHPStan\Type\Constant\ConstantBooleanType(\true), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\BooleanType(), new \PHPStan\Type\NullType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\BooleanType(), new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\BooleanType(), new \PHPStan\Type\FloatType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\BooleanType(), new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataAccepts
     * @param BooleanType  $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\BooleanType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSuperTypeOf() : iterable
    {
        (yield [new \PHPStan\Type\BooleanType(), new \PHPStan\Type\BooleanType(), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\BooleanType(), new \PHPStan\Type\Constant\ConstantBooleanType(\true), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\BooleanType(), new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\BooleanType(), new \PHPStan\Type\UnionType([new \PHPStan\Type\BooleanType(), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\BooleanType(), new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param BooleanType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\BooleanType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataEquals() : array
    {
        return [[new \PHPStan\Type\BooleanType(), new \PHPStan\Type\BooleanType(), \true], [new \PHPStan\Type\Constant\ConstantBooleanType(\false), new \PHPStan\Type\Constant\ConstantBooleanType(\false), \true], [new \PHPStan\Type\Constant\ConstantBooleanType(\true), new \PHPStan\Type\Constant\ConstantBooleanType(\false), \false], [new \PHPStan\Type\BooleanType(), new \PHPStan\Type\Constant\ConstantBooleanType(\false), \false], [new \PHPStan\Type\Constant\ConstantBooleanType(\false), new \PHPStan\Type\BooleanType(), \false], [new \PHPStan\Type\BooleanType(), new \PHPStan\Type\IntegerType(), \false], [new \PHPStan\Type\Constant\ConstantBooleanType(\false), new \PHPStan\Type\Constant\ConstantIntegerType(0), \false]];
    }
    /**
     * @dataProvider dataEquals
     * @param BooleanType $type
     * @param Type $otherType
     * @param bool $expectedResult
     */
    public function testEquals(\PHPStan\Type\BooleanType $type, \PHPStan\Type\Type $otherType, bool $expectedResult) : void
    {
        $actualResult = $type->equals($otherType);
        $this->assertSame($expectedResult, $actualResult, \sprintf('%s->equals(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
}
