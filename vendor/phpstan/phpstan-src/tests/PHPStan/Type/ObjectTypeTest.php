<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Accessory\HasMethodType;
use PHPStan\Type\Accessory\HasPropertyType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\Generic\TemplateTypeFactory;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\Generic\TemplateTypeVariance;
class ObjectTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsIterable() : array
    {
        return [[new \PHPStan\Type\ObjectType('ArrayObject'), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ObjectType('Traversable'), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ObjectType('Unknown'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ObjectType('DateTime'), \PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataIsIterable
     * @param ObjectType $type
     * @param TrinaryLogic $expectedResult
     */
    public function testIsIterable(\PHPStan\Type\ObjectType $type, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isIterable();
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isIterable()', $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsCallable() : array
    {
        return [[new \PHPStan\Type\ObjectType('Closure'), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ObjectType('Unknown'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ObjectType('DateTime'), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsCallable
     * @param ObjectType $type
     * @param TrinaryLogic $expectedResult
     */
    public function testIsCallable(\PHPStan\Type\ObjectType $type, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isCallable();
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isCallable()', $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSuperTypeOf() : array
    {
        return [0 => [new \PHPStan\Type\ObjectType('UnknownClassA'), new \PHPStan\Type\ObjectType('UnknownClassB'), \PHPStan\TrinaryLogic::createMaybe()], 1 => [new \PHPStan\Type\ObjectType(\ArrayAccess::class), new \PHPStan\Type\ObjectType(\Traversable::class), \PHPStan\TrinaryLogic::createMaybe()], 2 => [new \PHPStan\Type\ObjectType(\Countable::class), new \PHPStan\Type\ObjectType(\Countable::class), \PHPStan\TrinaryLogic::createYes()], 3 => [new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), \PHPStan\TrinaryLogic::createYes()], 4 => [new \PHPStan\Type\ObjectType(\Traversable::class), new \PHPStan\Type\ObjectType(\ArrayObject::class), \PHPStan\TrinaryLogic::createYes()], 5 => [new \PHPStan\Type\ObjectType(\Traversable::class), new \PHPStan\Type\ObjectType(\Iterator::class), \PHPStan\TrinaryLogic::createYes()], 6 => [new \PHPStan\Type\ObjectType(\ArrayObject::class), new \PHPStan\Type\ObjectType(\Traversable::class), \PHPStan\TrinaryLogic::createMaybe()], 7 => [new \PHPStan\Type\ObjectType(\Iterator::class), new \PHPStan\Type\ObjectType(\Traversable::class), \PHPStan\TrinaryLogic::createMaybe()], 8 => [new \PHPStan\Type\ObjectType(\ArrayObject::class), new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), \PHPStan\TrinaryLogic::createNo()], 9 => [new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createMaybe()], 10 => [new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType(\ArrayObject::class), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createNo()], 11 => [new \PHPStan\Type\ObjectType(\LogicException::class), new \PHPStan\Type\ObjectType(\InvalidArgumentException::class), \PHPStan\TrinaryLogic::createYes()], 12 => [new \PHPStan\Type\ObjectType(\InvalidArgumentException::class), new \PHPStan\Type\ObjectType(\LogicException::class), \PHPStan\TrinaryLogic::createMaybe()], 13 => [new \PHPStan\Type\ObjectType(\ArrayAccess::class), new \PHPStan\Type\StaticType(\Traversable::class), \PHPStan\TrinaryLogic::createMaybe()], 14 => [new \PHPStan\Type\ObjectType(\Countable::class), new \PHPStan\Type\StaticType(\Countable::class), \PHPStan\TrinaryLogic::createYes()], 15 => [new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\StaticType(\DateTimeImmutable::class), \PHPStan\TrinaryLogic::createYes()], 16 => [new \PHPStan\Type\ObjectType(\Traversable::class), new \PHPStan\Type\StaticType(\ArrayObject::class), \PHPStan\TrinaryLogic::createYes()], 17 => [new \PHPStan\Type\ObjectType(\Traversable::class), new \PHPStan\Type\StaticType(\Iterator::class), \PHPStan\TrinaryLogic::createYes()], 18 => [new \PHPStan\Type\ObjectType(\ArrayObject::class), new \PHPStan\Type\StaticType(\Traversable::class), \PHPStan\TrinaryLogic::createMaybe()], 19 => [new \PHPStan\Type\ObjectType(\Iterator::class), new \PHPStan\Type\StaticType(\Traversable::class), \PHPStan\TrinaryLogic::createMaybe()], 20 => [new \PHPStan\Type\ObjectType(\ArrayObject::class), new \PHPStan\Type\StaticType(\DateTimeImmutable::class), \PHPStan\TrinaryLogic::createNo()], 21 => [new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\UnionType([new \PHPStan\Type\StaticType(\DateTimeImmutable::class), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createMaybe()], 22 => [new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\UnionType([new \PHPStan\Type\StaticType(\ArrayObject::class), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createNo()], 23 => [new \PHPStan\Type\ObjectType(\LogicException::class), new \PHPStan\Type\StaticType(\InvalidArgumentException::class), \PHPStan\TrinaryLogic::createYes()], 24 => [new \PHPStan\Type\ObjectType(\InvalidArgumentException::class), new \PHPStan\Type\StaticType(\LogicException::class), \PHPStan\TrinaryLogic::createMaybe()], 25 => [new \PHPStan\Type\ObjectType(\stdClass::class), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createNo()], 26 => [new \PHPStan\Type\ObjectType(\Closure::class), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()], 27 => [new \PHPStan\Type\ObjectType(\Countable::class), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), \PHPStan\TrinaryLogic::createMaybe()], 28 => [new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\Accessory\HasMethodType('format'), \PHPStan\TrinaryLogic::createMaybe()], 29 => [new \PHPStan\Type\ObjectType(\Closure::class), new \PHPStan\Type\Accessory\HasMethodType('format'), \PHPStan\TrinaryLogic::createNo()], 30 => [new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\UnionType([new \PHPStan\Type\Accessory\HasMethodType('format'), new \PHPStan\Type\Accessory\HasMethodType('getTimestamp')]), \PHPStan\TrinaryLogic::createMaybe()], 31 => [new \PHPStan\Type\ObjectType(\DateInterval::class), new \PHPStan\Type\Accessory\HasPropertyType('d'), \PHPStan\TrinaryLogic::createMaybe()], 32 => [new \PHPStan\Type\ObjectType(\Closure::class), new \PHPStan\Type\Accessory\HasPropertyType('d'), \PHPStan\TrinaryLogic::createNo()], 33 => [new \PHPStan\Type\ObjectType(\DateInterval::class), new \PHPStan\Type\UnionType([new \PHPStan\Type\Accessory\HasPropertyType('d'), new \PHPStan\Type\Accessory\HasPropertyType('m')]), \PHPStan\TrinaryLogic::createMaybe()], 34 => [new \PHPStan\Type\ObjectType('Exception'), new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\TrinaryLogic::createMaybe()], 35 => [new \PHPStan\Type\ObjectType('Exception'), new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType('Exception')), \PHPStan\TrinaryLogic::createNo()], 36 => [new \PHPStan\Type\ObjectType('Exception'), new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType(\InvalidArgumentException::class)), \PHPStan\TrinaryLogic::createMaybe()], 37 => [new \PHPStan\Type\ObjectType(\InvalidArgumentException::class), new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType('Exception')), \PHPStan\TrinaryLogic::createNo()], 38 => [new \PHPStan\Type\ObjectType(\Throwable::class, new \PHPStan\Type\ObjectType(\InvalidArgumentException::class)), new \PHPStan\Type\ObjectType(\InvalidArgumentException::class), \PHPStan\TrinaryLogic::createNo()], 39 => [new \PHPStan\Type\ObjectType(\Throwable::class, new \PHPStan\Type\ObjectType(\InvalidArgumentException::class)), new \PHPStan\Type\ObjectType('Exception'), \PHPStan\TrinaryLogic::createYes()], 40 => [new \PHPStan\Type\ObjectType(\Throwable::class, new \PHPStan\Type\ObjectType('Exception')), new \PHPStan\Type\ObjectType(\InvalidArgumentException::class), \PHPStan\TrinaryLogic::createNo()], 41 => [new \PHPStan\Type\ObjectType(\Throwable::class, new \PHPStan\Type\ObjectType('Exception')), new \PHPStan\Type\ObjectType('Exception'), \PHPStan\TrinaryLogic::createNo()], 42 => [new \PHPStan\Type\ObjectType(\Throwable::class, new \PHPStan\Type\ObjectType('Exception')), new \PHPStan\Type\ObjectType(\Throwable::class), \PHPStan\TrinaryLogic::createYes()], 43 => [new \PHPStan\Type\ObjectType(\Throwable::class), new \PHPStan\Type\ObjectType(\Throwable::class, new \PHPStan\Type\ObjectType('Exception')), \PHPStan\TrinaryLogic::createYes()], 44 => [new \PHPStan\Type\ObjectType(\Throwable::class), new \PHPStan\Type\ObjectType(\Throwable::class, new \PHPStan\Type\ObjectType('Exception')), \PHPStan\TrinaryLogic::createYes()], 45 => [new \PHPStan\Type\ObjectType('Exception'), new \PHPStan\Type\ObjectType(\Throwable::class, new \PHPStan\Type\ObjectType('Exception')), \PHPStan\TrinaryLogic::createNo()], 46 => [new \PHPStan\Type\ObjectType(\DateTimeInterface::class), \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithClass(\DateTimeInterface::class), 'T', new \PHPStan\Type\ObjectType(\DateTimeInterface::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant()), \PHPStan\TrinaryLogic::createYes()], 47 => [new \PHPStan\Type\ObjectType(\DateTimeInterface::class), \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithClass(\DateTime::class), 'T', new \PHPStan\Type\ObjectType(\DateTime::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant()), \PHPStan\TrinaryLogic::createYes()], 48 => [new \PHPStan\Type\ObjectType(\DateTime::class), \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithClass(\DateTimeInterface::class), 'T', new \PHPStan\Type\ObjectType(\DateTimeInterface::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant()), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param ObjectType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\ObjectType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataAccepts() : array
    {
        return [[new \PHPStan\Type\ObjectType(\SimpleXMLElement::class), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\ObjectType(\SimpleXMLElement::class), new \PHPStan\Type\Constant\ConstantStringType('foo'), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\ObjectType(\Traversable::class), new \PHPStan\Type\Generic\GenericObjectType(\Traversable::class, [new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\ObjectType('DateTimeInteface')]), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ObjectType(\DateTimeInterface::class), \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithClass(\DateTimeInterface::class), 'T', new \PHPStan\Type\ObjectType(\DateTimeInterface::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant()), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ObjectType(\DateTime::class), \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithClass(\DateTimeInterface::class), 'T', new \PHPStan\Type\ObjectType(\DateTimeInterface::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant()), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataAccepts
     * @param \PHPStan\Type\ObjectType $type
     * @param Type $acceptedType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\ObjectType $type, \PHPStan\Type\Type $acceptedType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $this->assertSame($expectedResult->describe(), $type->accepts($acceptedType, \true)->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $acceptedType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function testGetClassReflectionOfGenericClass() : void
    {
        $objectType = new \PHPStan\Type\ObjectType(\Traversable::class);
        $classReflection = $objectType->getClassReflection();
        $this->assertNotNull($classReflection);
        $this->assertSame('Traversable<mixed,mixed>', $classReflection->getDisplayName());
    }
    public function dataHasOffsetValueType() : array
    {
        return [[new \PHPStan\Type\ObjectType(\stdClass::class), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ObjectType(\Generator::class), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\ObjectType(\ArrayAccess::class), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ObjectType(\Countable::class), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Generic\GenericObjectType(\ArrayAccess::class, [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\MixedType()]), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Generic\GenericObjectType(\ArrayAccess::class, [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\MixedType()]), new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Generic\GenericObjectType(\ArrayAccess::class, [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\MixedType()]), new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\Generic\GenericObjectType(\ArrayAccess::class, [new \PHPStan\Type\ObjectType(\DateTimeInterface::class), new \PHPStan\Type\MixedType()]), new \PHPStan\Type\ObjectType(\DateTime::class), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Generic\GenericObjectType(\ArrayAccess::class, [new \PHPStan\Type\ObjectType(\DateTime::class), new \PHPStan\Type\MixedType()]), new \PHPStan\Type\ObjectType(\DateTimeInterface::class), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\Generic\GenericObjectType(\ArrayAccess::class, [new \PHPStan\Type\ObjectType(\DateTime::class), new \PHPStan\Type\MixedType()]), new \PHPStan\Type\ObjectType(\stdClass::class), \PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataHasOffsetValueType
     * @param \PHPStan\Type\ObjectType $type
     * @param Type $offsetType
     * @param TrinaryLogic $expectedResult
     */
    public function testHasOffsetValueType(\PHPStan\Type\ObjectType $type, \PHPStan\Type\Type $offsetType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $this->assertSame($expectedResult->describe(), $type->hasOffsetValueType($offsetType)->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $offsetType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
}
