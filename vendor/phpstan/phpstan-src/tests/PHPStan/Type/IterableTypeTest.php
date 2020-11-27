<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Accessory\HasMethodType;
use PHPStan\Type\Accessory\HasPropertyType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Generic\TemplateMixedType;
use PHPStan\Type\Generic\TemplateTypeFactory;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\Generic\TemplateTypeVariance;
class IterableTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \PHPStan\Type\IterableType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\StringType()), new \PHPStan\Type\ObjectType('Iterator'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\false), new \PHPStan\Type\MixedType(\true)), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param IterableType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\IterableType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSubTypeOf() : array
    {
        return [[new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\ObjectType('Unknown'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\IntegerType()), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\UnionType([new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\NullType()]), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\UnionType([new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\ObjectType('Traversable')]), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\UnionType([new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\ObjectType('Traversable')]), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('Unknown'), new \PHPStan\Type\NullType()]), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\NullType()]), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\UnionType([new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\IntegerType()), new \PHPStan\Type\NullType()]), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\IterableType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\IterableType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\Accessory\HasMethodType('foo'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\Accessory\HasPropertyType('foo'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\StringType()), new \PHPStan\Type\ObjectType('Iterator'), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param IterableType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOf(\PHPStan\Type\IterableType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSubTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSubTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param IterableType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOfInversed(\PHPStan\Type\IterableType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $otherType->isSuperTypeOf($type);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $otherType->describe(\PHPStan\Type\VerbosityLevel::precise()), $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataInferTemplateTypes() : array
    {
        $templateType = static function (string $name) : Type {
            return \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), $name, new \PHPStan\Type\MixedType(), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return ['receive iterable' => [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('DateTime')), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), $templateType('T')), ['T' => 'DateTime']], 'receive iterable template key' => [new \PHPStan\Type\IterableType(new \PHPStan\Type\StringType(), new \PHPStan\Type\ObjectType('DateTime')), new \PHPStan\Type\IterableType($templateType('U'), $templateType('T')), ['U' => 'string', 'T' => 'DateTime']], 'receive mixed' => [new \PHPStan\Type\MixedType(), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), $templateType('T')), []], 'receive non-accepted' => [new \PHPStan\Type\StringType(), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), $templateType('T')), []]];
    }
    /**
     * @dataProvider dataInferTemplateTypes
     * @param array<string,string> $expectedTypes
     */
    public function testResolveTemplateTypes(\PHPStan\Type\Type $received, \PHPStan\Type\Type $template, array $expectedTypes) : void
    {
        $result = $template->inferTemplateTypes($received);
        $this->assertSame($expectedTypes, \array_map(static function (\PHPStan\Type\Type $type) : string {
            return $type->describe(\PHPStan\Type\VerbosityLevel::precise());
        }, $result->getTypes()));
    }
    public function dataDescribe() : array
    {
        $templateType = \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), 'T', null, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        return [[new \PHPStan\Type\IterableType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), 'iterable<int, string>'], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), 'iterable<string>'], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), 'iterable'], [new \PHPStan\Type\IterableType($templateType, new \PHPStan\Type\MixedType()), 'iterable<T, mixed>'], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), $templateType), 'iterable<T>'], [new \PHPStan\Type\IterableType($templateType, $templateType), 'iterable<T, T>']];
    }
    /**
     * @dataProvider dataDescribe
     */
    public function testDescribe(\PHPStan\Type\Type $type, string $expect) : void
    {
        $result = $type->describe(\PHPStan\Type\VerbosityLevel::typeOnly());
        $this->assertSame($expect, $result);
    }
    public function dataAccepts() : array
    {
        /** @var TemplateMixedType $t */
        $t = \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', null, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        return [[new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), $t), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), $t->toArgument()), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataAccepts
     * @param IterableType $iterableType
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\IterableType $iterableType, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $iterableType->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $iterableType->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
}
