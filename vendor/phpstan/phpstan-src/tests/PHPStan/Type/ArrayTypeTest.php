<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Broker\Broker;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Generic\TemplateTypeFactory;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\Generic\TemplateTypeVariance;
class ArrayTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\IntegerType()), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\ArrayType(new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\CallableType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType(\false, \PHPStan\Type\StaticTypeFactory::falsey())), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType(\false, new \PHPStan\Type\NullType())), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param ArrayType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\ArrayType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataAccepts() : array
    {
        $reflectionProvider = \PHPStan\Broker\Broker::getInstance();
        return [[new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), \PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantArrayType([], []), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0)], [new \PHPStan\Type\MixedType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType()])), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\CallableType()), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\ThisType($reflectionProvider->getClass(self::class)), new \PHPStan\Type\Constant\ConstantStringType('dataAccepts')]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\ThisType($reflectionProvider->getClass(self::class)), new \PHPStan\Type\Constant\ConstantStringType('dataIsSuperTypeOf')])]), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataAccepts
     * @param ArrayType $acceptingType
     * @param Type $acceptedType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\ArrayType $acceptingType, \PHPStan\Type\Type $acceptedType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $acceptingType->accepts($acceptedType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $acceptingType->describe(\PHPStan\Type\VerbosityLevel::precise()), $acceptedType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataDescribe() : array
    {
        return [[new \PHPStan\Type\ArrayType(new \PHPStan\Type\BenevolentUnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\StringType()]), new \PHPStan\Type\IntegerType()), 'array<int>']];
    }
    /**
     * @dataProvider dataDescribe
     * @param ArrayType $type
     * @param string $expectedDescription
     */
    public function testDescribe(\PHPStan\Type\ArrayType $type, string $expectedDescription) : void
    {
        $this->assertSame($expectedDescription, $type->describe(\PHPStan\Type\VerbosityLevel::precise()));
    }
    public function dataInferTemplateTypes() : array
    {
        $templateType = static function (string $name) : Type {
            return \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), $name, new \PHPStan\Type\MixedType(), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return ['valid templated item' => [new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType('DateTime')), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $templateType('T')), ['T' => 'DateTime']], 'receive mixed' => [new \PHPStan\Type\MixedType(), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $templateType('T')), []], 'receive non-accepted' => [new \PHPStan\Type\StringType(), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $templateType('T')), []], 'receive union items' => [new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()])), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $templateType('T')), ['T' => 'int|string']], 'receive union' => [new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\IntegerType())]), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $templateType('T')), ['T' => 'int|string']]];
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
}
