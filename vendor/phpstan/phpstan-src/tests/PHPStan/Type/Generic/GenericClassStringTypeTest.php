<?php

declare (strict_types=1);
namespace PHPStan\Type\Generic;

use PHPStan\TrinaryLogic;
use PHPStan\Type\BenevolentUnionType;
use PHPStan\Type\ClassStringType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ObjectWithoutClassType;
use PHPStan\Type\StaticType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
class GenericClassStringTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [0 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\ClassStringType(), \PHPStan\TrinaryLogic::createMaybe()], 1 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createMaybe()], 2 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), \PHPStan\TrinaryLogic::createYes()], 3 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Throwable::class)), \PHPStan\TrinaryLogic::createMaybe()], 4 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\InvalidArgumentException::class)), \PHPStan\TrinaryLogic::createYes()], 5 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\stdClass::class)), \PHPStan\TrinaryLogic::createNo()], 6 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), \PHPStan\TrinaryLogic::createYes()], 7 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Throwable::class)), new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), \PHPStan\TrinaryLogic::createYes()], 8 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\InvalidArgumentException::class)), new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), \PHPStan\TrinaryLogic::createNo()], 9 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\stdClass::class)), new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), \PHPStan\TrinaryLogic::createNo()], 10 => [new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', null, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), \PHPStan\TrinaryLogic::createYes()], 11 => [new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', new \PHPStan\Type\ObjectType(\Exception::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), \PHPStan\TrinaryLogic::createYes()], 12 => [new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', new \PHPStan\Type\ObjectType(\Exception::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \PHPStan\Type\Constant\ConstantStringType(\stdClass::class), \PHPStan\TrinaryLogic::createNo()], 13 => [new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', new \PHPStan\Type\ObjectType(\Exception::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \PHPStan\Type\Constant\ConstantStringType(\InvalidArgumentException::class), \PHPStan\TrinaryLogic::createYes()], 14 => [new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', new \PHPStan\Type\ObjectType(\Exception::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \PHPStan\Type\Constant\ConstantStringType(\Throwable::class), \PHPStan\TrinaryLogic::createNo()], 15 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\StaticType(\Exception::class)), new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), \PHPStan\TrinaryLogic::createYes()], 16 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\StaticType(\InvalidArgumentException::class)), new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), \PHPStan\TrinaryLogic::createNo()], 17 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\StaticType(\Throwable::class)), new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     */
    public function testIsSuperTypeOf(\PHPStan\Type\Generic\GenericClassStringType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataAccepts() : array
    {
        return [0 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\Constant\ConstantStringType(\Throwable::class), \PHPStan\TrinaryLogic::createNo()], 1 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), \PHPStan\TrinaryLogic::createYes()], 2 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\Constant\ConstantStringType(\InvalidArgumentException::class), \PHPStan\TrinaryLogic::createYes()], 3 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createMaybe()], 4 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\ObjectType(\Exception::class), \PHPStan\TrinaryLogic::createNo()], 5 => [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), \PHPStan\TrinaryLogic::createYes()], 6 => [new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', null, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \PHPStan\Type\Constant\ConstantStringType('NonexistentClass'), \PHPStan\TrinaryLogic::createNo()], 7 => [new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Foo'), 'T', null, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantStringType(\DateTime::class), new \PHPStan\Type\Constant\ConstantStringType(\Exception::class)]), \PHPStan\TrinaryLogic::createYes()], 8 => [new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Foo'), 'T', new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \PHPStan\Type\ClassStringType(), \PHPStan\TrinaryLogic::createYes()], 9 => [new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Foo'), 'T', new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Boo'), 'U', new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), \PHPStan\TrinaryLogic::createMaybe()], 10 => [new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Foo'), 'T', new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createMaybe()], 11 => [new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Foo'), 'T', new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), new \PHPStan\Type\BenevolentUnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataAccepts
     */
    public function testAccepts(\PHPStan\Type\Generic\GenericClassStringType $acceptingType, \PHPStan\Type\Type $acceptedType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $acceptingType->accepts($acceptedType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $acceptingType->describe(\PHPStan\Type\VerbosityLevel::precise()), $acceptedType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataEquals() : array
    {
        return [[new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), \true], [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\stdClass::class)), \false], [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\StaticType(\Exception::class)), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\StaticType(\Exception::class)), \true], [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\StaticType(\Exception::class)), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\StaticType(\stdClass::class)), \false]];
    }
    /**
     * @dataProvider dataEquals
     */
    public function testEquals(\PHPStan\Type\Generic\GenericClassStringType $type, \PHPStan\Type\Type $otherType, bool $expected) : void
    {
        $verbosityLevel = \PHPStan\Type\VerbosityLevel::precise();
        $typeDescription = $type->describe($verbosityLevel);
        $otherTypeDescription = $otherType->describe($verbosityLevel);
        $actual = $type->equals($otherType);
        $this->assertSame($expected, $actual, \sprintf('%s -> equals(%s)', $typeDescription, $otherTypeDescription));
        $actual = $otherType->equals($type);
        $this->assertSame($expected, $actual, \sprintf('%s -> equals(%s)', $otherTypeDescription, $typeDescription));
    }
}
