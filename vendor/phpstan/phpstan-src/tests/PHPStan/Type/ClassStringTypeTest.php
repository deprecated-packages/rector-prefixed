<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Testing\TestCase;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Generic\GenericClassStringType;
class ClassStringTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\Constant\ConstantStringType(\stdClass::class), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\Constant\ConstantStringType('Nonexistent'), \PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     */
    public function testIsSuperTypeOf(\PHPStan\Type\ClassStringType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataAccepts() : iterable
    {
        (yield [new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\ClassStringType(), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\Constant\ConstantStringType(\stdClass::class), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\Constant\ConstantStringType('NonexistentClass'), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantStringType(\stdClass::class), new \PHPStan\Type\Constant\ConstantStringType(self::class)]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantStringType(\stdClass::class), new \PHPStan\Type\Constant\ConstantStringType('Nonexistent')]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantStringType('Nonexistent'), new \PHPStan\Type\Constant\ConstantStringType('Nonexistent2')]), \PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataAccepts
     * @param \PHPStan\Type\ClassStringType $type
     * @param Type $otherType
     * @param \PHPStan\TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\ClassStringType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataEquals() : array
    {
        return [[new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\ClassStringType(), \true], [new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\StringType(), \false]];
    }
    /**
     * @dataProvider dataEquals
     * @param ClassStringType $type
     * @param Type $otherType
     * @param bool $expectedResult
     */
    public function testEquals(\PHPStan\Type\ClassStringType $type, \PHPStan\Type\Type $otherType, bool $expectedResult) : void
    {
        $actualResult = $type->equals($otherType);
        $this->assertSame($expectedResult, $actualResult, \sprintf('%s->equals(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
}
