<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
class ClosureTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\ObjectType(\Closure::class), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ClosureType([], new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]), \false), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\IntegerType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\CallableType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ObjectType(\Closure::class), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ClosureType([], new \PHPStan\Type\IntegerType(), \false), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]), \false), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ClosureType([], new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]), \false), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\IntegerType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ObjectWithoutClassType(), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false)), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType(\Closure::class)), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType(\Closure::class)), \PHPStan\TrinaryLogic::createNo()]];
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
}
