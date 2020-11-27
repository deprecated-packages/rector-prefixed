<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Reflection\Native\NativeParameterReflection;
use PHPStan\Reflection\PassedByReference;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Accessory\AccessoryNumericStringType;
use PHPStan\Type\Accessory\HasMethodType;
use PHPStan\Type\Accessory\HasOffsetType;
use PHPStan\Type\Accessory\HasPropertyType;
use PHPStan\Type\Accessory\NonEmptyArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantBooleanType;
use PHPStan\Type\Constant\ConstantFloatType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\Generic\TemplateTypeFactory;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\Generic\TemplateTypeVariance;
class UnionTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsCallable() : array
    {
        return [[\PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantStringType('Closure'), new \PHPStan\Type\Constant\ConstantStringType('bind')]), new \PHPStan\Type\Constant\ConstantStringType('array_push')), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\ObjectType('Closure')]), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()]), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsCallable
     * @param UnionType $type
     * @param TrinaryLogic $expectedResult
     */
    public function testIsCallable(\PHPStan\Type\UnionType $type, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isCallable();
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isCallable()', $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataSelfCompare() : \Iterator
    {
        $broker = $this->createBroker();
        $integerType = new \PHPStan\Type\IntegerType();
        $stringType = new \PHPStan\Type\StringType();
        $mixedType = new \PHPStan\Type\MixedType();
        $constantStringType = new \PHPStan\Type\Constant\ConstantStringType('foo');
        $constantIntegerType = new \PHPStan\Type\Constant\ConstantIntegerType(42);
        $templateTypeScope = \PHPStan\Type\Generic\TemplateTypeScope::createWithClass('Foo');
        $mixedParam = new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, $mixedType, \PHPStan\Reflection\PassedByReference::createNo(), \false, null);
        $integerParam = new \PHPStan\Reflection\Native\NativeParameterReflection('n', \false, $integerType, \PHPStan\Reflection\PassedByReference::createNo(), \false, null);
        (yield [new \PHPStan\Type\Accessory\AccessoryNumericStringType()]);
        (yield [new \PHPStan\Type\ArrayType($integerType, $stringType)]);
        (yield [new \PHPStan\Type\ArrayType($stringType, $mixedType)]);
        (yield [new \PHPStan\Type\BenevolentUnionType([$integerType, $stringType])]);
        (yield [new \PHPStan\Type\BooleanType()]);
        (yield [new \PHPStan\Type\CallableType()]);
        (yield [new \PHPStan\Type\CallableType([$mixedParam, $integerParam], $stringType, \false)]);
        (yield [new \PHPStan\Type\ClassStringType()]);
        (yield [new \PHPStan\Type\ClosureType([$mixedParam, $integerParam], $stringType, \false)]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([$constantStringType, $constantIntegerType], [$mixedType, $stringType], 10, [1])]);
        (yield [new \PHPStan\Type\Constant\ConstantBooleanType(\true)]);
        (yield [new \PHPStan\Type\Constant\ConstantFloatType(3.14)]);
        (yield [$constantIntegerType]);
        (yield [$constantStringType]);
        (yield [new \PHPStan\Type\ErrorType()]);
        (yield [new \PHPStan\Type\FloatType()]);
        (yield [new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class))]);
        (yield [new \PHPStan\Type\Generic\GenericObjectType('Foo', [new \PHPStan\Type\ObjectType('DateTime')])]);
        (yield [new \PHPStan\Type\Accessory\HasMethodType('Foo')]);
        (yield [new \PHPStan\Type\Accessory\HasOffsetType($constantStringType)]);
        (yield [new \PHPStan\Type\Accessory\HasPropertyType('foo')]);
        (yield [\PHPStan\Type\IntegerRangeType::fromInterval(3, 10)]);
        (yield [$integerType]);
        (yield [new \PHPStan\Type\IntersectionType([new \PHPStan\Type\Accessory\HasMethodType('Foo'), new \PHPStan\Type\Accessory\HasPropertyType('bar')])]);
        (yield [new \PHPStan\Type\IterableType($integerType, $stringType)]);
        (yield [$mixedType]);
        (yield [new \PHPStan\Type\NeverType()]);
        (yield [new \PHPStan\Type\Accessory\NonEmptyArrayType()]);
        (yield [new \PHPStan\Type\NonexistentParentClassType()]);
        (yield [new \PHPStan\Type\NullType()]);
        (yield [new \PHPStan\Type\ObjectType('Foo')]);
        (yield [new \PHPStan\Type\ObjectWithoutClassType(new \PHPStan\Type\ObjectType('Foo'))]);
        (yield [new \PHPStan\Type\ResourceType()]);
        (yield [new \PHPStan\Type\StaticType('Foo')]);
        (yield [new \PHPStan\Type\StrictMixedType()]);
        (yield [new \PHPStan\Type\StringAlwaysAcceptingObjectWithToStringType()]);
        (yield [$stringType]);
        (yield [\PHPStan\Type\Generic\TemplateTypeFactory::create($templateTypeScope, 'T', null, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())]);
        (yield [\PHPStan\Type\Generic\TemplateTypeFactory::create($templateTypeScope, 'T', new \PHPStan\Type\ObjectType('Foo'), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())]);
        (yield [\PHPStan\Type\Generic\TemplateTypeFactory::create($templateTypeScope, 'T', new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())]);
        (yield [new \PHPStan\Type\ThisType($broker->getClass('Foo'))]);
        (yield [new \PHPStan\Type\UnionType([$integerType, $stringType])]);
        (yield [new \PHPStan\Type\VoidType()]);
    }
    /**
     * @dataProvider dataSelfCompare
     *
     * @param  Type $type
     */
    public function testSelfCompare(\PHPStan\Type\Type $type) : void
    {
        $description = $type->describe(\PHPStan\Type\VerbosityLevel::precise());
        $this->assertTrue($type->equals($type), \sprintf('%s -> equals(itself)', $description));
        $this->assertEquals('Yes', $type->isSuperTypeOf($type)->describe(), \sprintf('%s -> isSuperTypeOf(itself)', $description));
        $this->assertInstanceOf(\get_class($type), \PHPStan\Type\TypeCombinator::union($type, $type), \sprintf('%s -> union with itself is same type', $description));
    }
    public function dataIsSuperTypeOf() : \Iterator
    {
        $unionTypeA = new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]);
        (yield [$unionTypeA, $unionTypeA->getTypes()[0], \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, $unionTypeA->getTypes()[1], \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, $unionTypeA, \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\CallableType()]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \PHPStan\Type\CallableType(), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType()]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \PHPStan\Type\UnionType([new \PHPStan\Type\CallableType(), new \PHPStan\Type\FloatType()]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\MixedType(), new \PHPStan\Type\CallableType()]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \PHPStan\Type\FloatType(), \PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeA, new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantBooleanType(\true), new \PHPStan\Type\FloatType()]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeA, new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), \PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeA, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\CallableType()]), \PHPStan\TrinaryLogic::createNo()]);
        $unionTypeB = new \PHPStan\Type\UnionType([new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType('ArrayObject'), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('DatePeriod'))]), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('DatePeriod'))]);
        (yield [$unionTypeB, $unionTypeB->getTypes()[0], \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeB, $unionTypeB->getTypes()[1], \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeB, $unionTypeB, \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeB, new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \PHPStan\Type\ObjectType('ArrayObject'), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('DatePeriod')), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeB, new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeB, new \PHPStan\Type\ObjectType('Foo'), \PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeB, new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('DateTime')), \PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeB, new \PHPStan\Type\CallableType(), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\MixedType(), new \PHPStan\Type\CallableType()]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\CallableType()]), \PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param UnionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\UnionType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSubTypeOf() : \Iterator
    {
        $unionTypeA = new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]);
        (yield [$unionTypeA, $unionTypeA, \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, new \PHPStan\Type\UnionType(\array_merge($unionTypeA->getTypes(), [new \PHPStan\Type\ResourceType()])), \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeA, $unionTypeA->getTypes()[0], \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, $unionTypeA->getTypes()[1], \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \PHPStan\Type\CallableType(), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType()]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \PHPStan\Type\UnionType([new \PHPStan\Type\CallableType(), new \PHPStan\Type\FloatType()]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\CallableType()]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\MixedType(), new \PHPStan\Type\CallableType()]), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeA, new \PHPStan\Type\FloatType(), \PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeA, new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantBooleanType(\true), new \PHPStan\Type\FloatType()]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeA, new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), \PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeA, new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\CallableType()]), \PHPStan\TrinaryLogic::createNo()]);
        $unionTypeB = new \PHPStan\Type\UnionType([new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType('ArrayObject'), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item')), new \PHPStan\Type\CallableType()]), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('Item'))]);
        (yield [$unionTypeB, $unionTypeB, \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeB, new \PHPStan\Type\UnionType(\array_merge($unionTypeB->getTypes(), [new \PHPStan\Type\StringType()])), \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeB, new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createYes()]);
        (yield [$unionTypeB, $unionTypeB->getTypes()[0], \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, $unionTypeB->getTypes()[1], \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \PHPStan\Type\ObjectType('ArrayObject'), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \PHPStan\Type\CallableType(), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [$unionTypeB, new \PHPStan\Type\FloatType(), \PHPStan\TrinaryLogic::createNo()]);
        (yield [$unionTypeB, new \PHPStan\Type\ObjectType('Foo'), \PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param UnionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOf(\PHPStan\Type\UnionType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSubTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSubTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param UnionType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOfInversed(\PHPStan\Type\UnionType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $otherType->isSuperTypeOf($type);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $otherType->describe(\PHPStan\Type\VerbosityLevel::precise()), $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataDescribe() : array
    {
        return [[new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]), 'int|string', 'int|string'], [new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType(), new \PHPStan\Type\NullType()]), 'int|string|null', 'int|string|null'], [new \PHPStan\Type\UnionType([new \PHPStan\Type\Constant\ConstantStringType('1aaa'), new \PHPStan\Type\Constant\ConstantStringType('11aaa'), new \PHPStan\Type\Constant\ConstantStringType('2aaa'), new \PHPStan\Type\Constant\ConstantStringType('10aaa'), new \PHPStan\Type\Constant\ConstantIntegerType(2), new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(10), new \PHPStan\Type\Constant\ConstantFloatType(2.2), new \PHPStan\Type\NullType(), new \PHPStan\Type\Constant\ConstantStringType('10'), new \PHPStan\Type\ObjectType(\stdClass::class), new \PHPStan\Type\Constant\ConstantBooleanType(\true), new \PHPStan\Type\Constant\ConstantStringType('foo'), new \PHPStan\Type\Constant\ConstantStringType('2'), new \PHPStan\Type\Constant\ConstantStringType('1')]), "1|2|2.2|10|'1'|'10'|'10aaa'|'11aaa'|'1aaa'|'2'|'2aaa'|'foo'|stdClass|true|null", 'float|int|stdClass|string|true|null'], [\PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\BooleanType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b')], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType()]), new \PHPStan\Type\Constant\ConstantStringType('aaa')), '\'aaa\'|array(\'a\' => int|string, \'b\' => bool|float)', 'array<string, bool|float|int|string>|string'], [\PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\BooleanType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('b'), new \PHPStan\Type\Constant\ConstantStringType('c')], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType()]), new \PHPStan\Type\Constant\ConstantStringType('aaa')), '\'aaa\'|array(\'a\' => string, \'b\' => bool)|array(\'b\' => int, \'c\' => float)', 'array<string, bool|float|int|string>|string'], [\PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\BooleanType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('c'), new \PHPStan\Type\Constant\ConstantStringType('d')], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\FloatType()]), new \PHPStan\Type\Constant\ConstantStringType('aaa')), '\'aaa\'|array(\'a\' => string, \'b\' => bool)|array(\'c\' => int, \'d\' => float)', 'array<string, bool|float|int|string>|string'], [\PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0)], [new \PHPStan\Type\StringType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantIntegerType(2)], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\BooleanType(), new \PHPStan\Type\FloatType()])), 'array(0 => int|string, ?1 => bool, ?2 => float)', 'array<int, bool|float|int|string>'], [\PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantArrayType([], []), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foooo')], [new \PHPStan\Type\Constant\ConstantStringType('barrr')])), 'array()|array(\'foooo\' => \'barrr\')', 'array<string, string>'], [\PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\Accessory\AccessoryNumericStringType()])), 'int|(string&numeric)', 'int|string']];
    }
    /**
     * @dataProvider dataDescribe
     * @param Type $type
     * @param string $expectedValueDescription
     * @param string $expectedTypeOnlyDescription
     */
    public function testDescribe(\PHPStan\Type\Type $type, string $expectedValueDescription, string $expectedTypeOnlyDescription) : void
    {
        $this->assertSame($expectedValueDescription, $type->describe(\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertSame($expectedTypeOnlyDescription, $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly()));
    }
    public function dataAccepts() : array
    {
        return [[new \PHPStan\Type\UnionType([new \PHPStan\Type\CallableType(), new \PHPStan\Type\NullType()]), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\StringType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\CallableType(), new \PHPStan\Type\NullType()]), new \PHPStan\Type\UnionType([new \PHPStan\Type\ClosureType([], new \PHPStan\Type\StringType(), \false), new \PHPStan\Type\BooleanType()]), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\CallableType(), new \PHPStan\Type\NullType()]), new \PHPStan\Type\BooleanType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\StringType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\StringType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\BooleanType(), \false), new \PHPStan\Type\NullType()]), new \PHPStan\Type\CallableType(), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\StringType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\StringType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\BooleanType(), \false), new \PHPStan\Type\NullType()]), new \PHPStan\Type\BooleanType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\ClosureType([new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\StringType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\StringType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\BooleanType(), \false), new \PHPStan\Type\NullType()]), new \PHPStan\Type\CallableType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\ClosureType([new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\StringType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\StringType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('a', \false, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\BooleanType(), \false), new \PHPStan\Type\NullType()]), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataAccepts
     * @param UnionType $type
     * @param Type $acceptedType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\UnionType $type, \PHPStan\Type\Type $acceptedType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $this->assertSame($expectedResult->describe(), $type->accepts($acceptedType, \true)->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $acceptedType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataHasMethod() : array
    {
        return [[new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\IntegerType()]), 'format', \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\ObjectType(\DateTime::class)]), 'format', \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\FloatType(), new \PHPStan\Type\IntegerType()]), 'format', \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType(\DateTimeImmutable::class), new \PHPStan\Type\NullType()]), 'format', \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataHasMethod
     * @param UnionType $type
     * @param string $methodName
     * @param TrinaryLogic $expectedResult
     */
    public function testHasMethod(\PHPStan\Type\UnionType $type, string $methodName, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $this->assertSame($expectedResult->describe(), $type->hasMethod($methodName)->describe());
    }
    public function testSorting() : void
    {
        $types = [new \PHPStan\Type\Constant\ConstantBooleanType(\false), new \PHPStan\Type\Constant\ConstantBooleanType(\true), new \PHPStan\Type\Constant\ConstantIntegerType(-1), new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1), new \PHPStan\Type\Constant\ConstantFloatType(-1.0), new \PHPStan\Type\Constant\ConstantFloatType(0.0), new \PHPStan\Type\Constant\ConstantFloatType(1.0), new \PHPStan\Type\Constant\ConstantStringType(''), new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b'), new \PHPStan\Type\Constant\ConstantArrayType([], []), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('')], [new \PHPStan\Type\Constant\ConstantStringType('')]), new \PHPStan\Type\IntegerType(), \PHPStan\Type\IntegerRangeType::fromInterval(10, 20), \PHPStan\Type\IntegerRangeType::fromInterval(30, 40), new \PHPStan\Type\FloatType(), new \PHPStan\Type\StringType(), new \PHPStan\Type\ClassStringType(), new \PHPStan\Type\MixedType()];
        $type1 = new \PHPStan\Type\UnionType($types);
        $type2 = new \PHPStan\Type\UnionType(\array_reverse($types));
        $this->assertTrue($type1->equals($type2), 'UnionType sorting always produces the same order');
    }
}
