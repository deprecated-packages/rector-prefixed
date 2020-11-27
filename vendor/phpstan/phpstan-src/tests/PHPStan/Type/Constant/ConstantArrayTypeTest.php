<?php

declare (strict_types=1);
namespace PHPStan\Type\Constant;

use PHPStan\TrinaryLogic;
use PHPStan\Type\ArrayType;
use PHPStan\Type\CallableType;
use PHPStan\Type\Generic\TemplateTypeFactory;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\VerbosityLevel;
class ConstantArrayTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataAccepts() : iterable
    {
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([], []), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([], []), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(7)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(7)]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType()), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\ArrayType(new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\IntegerType()), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo')], [new \PHPStan\Type\CallableType()]), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo')], [new \PHPStan\Type\StringType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo'), new \PHPStan\Type\Constant\ConstantStringType('bar')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo')], [new \PHPStan\Type\StringType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('bar')], [new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo')], [new \PHPStan\Type\StringType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo')], [new \PHPStan\Type\Constant\ConstantStringType('bar')]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [\PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('name')], [new \PHPStan\Type\StringType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('name'), new \PHPStan\Type\Constant\ConstantStringType('color')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()])), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('name'), new \PHPStan\Type\Constant\ConstantStringType('color'), new \PHPStan\Type\Constant\ConstantStringType('year')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('name'), new \PHPStan\Type\Constant\ConstantStringType('color'), new \PHPStan\Type\Constant\ConstantStringType('year')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()]), new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createYes()]);
        (yield [\PHPStan\Type\TypeCombinator::union(new \PHPStan\Type\Constant\ConstantArrayType([], []), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('name'), new \PHPStan\Type\Constant\ConstantStringType('color')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()])), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('surname')], [new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('sorton'), new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()], 0, [0, 1]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('sorton'), new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\Constant\ConstantStringType('test'), new \PHPStan\Type\Constant\ConstantStringType('true')]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('sorton'), new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('sorton'), new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\Constant\ConstantStringType('test'), new \PHPStan\Type\Constant\ConstantStringType('true')]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('sorton'), new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()], 0, [1]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('sorton'), new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\Constant\ConstantStringType('test'), new \PHPStan\Type\Constant\ConstantStringType('true')]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\IntegerType()], 0, [0]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\Constant\ConstantStringType('true')]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\IntegerType()], 0), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\Constant\ConstantStringType('true')]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('sorton'), new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()], 0, [0, 1]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('sorton'), new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\Constant\ConstantStringType('test'), new \PHPStan\Type\Constant\ConstantStringType('true')]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('name'), new \PHPStan\Type\Constant\ConstantStringType('color')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()], 0, [0, 1]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('color')], [new \PHPStan\Type\Constant\ConstantStringType('test')]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('name'), new \PHPStan\Type\Constant\ConstantStringType('color')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()], 0, [0, 1]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('sound')], [new \PHPStan\Type\Constant\ConstantStringType('test')]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo'), new \PHPStan\Type\Constant\ConstantStringType('bar')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()], 0, [0, 1]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo'), new \PHPStan\Type\Constant\ConstantStringType('bar')], [new \PHPStan\Type\Constant\ConstantStringType('s'), new \PHPStan\Type\Constant\ConstantStringType('m')], 0, [0, 1]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('sorton'), new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()], 0, [0, 1]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('sorton'), new \PHPStan\Type\Constant\ConstantStringType('limit')], [new \PHPStan\Type\Constant\ConstantStringType('test'), new \PHPStan\Type\Constant\ConstantStringType('true')]), \PHPStan\TrinaryLogic::createNo()]);
    }
    /**
     * @dataProvider dataAccepts
     * @param Type $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\Type $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSuperTypeOf() : iterable
    {
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([], []), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([], []), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(7)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(7)]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\ArrayType(new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType()), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\ArrayType(new \PHPStan\Type\StringType(), new \PHPStan\Type\StringType()), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantIntegerType(2)]), new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([], []), new \PHPStan\Type\IterableType(new \PHPStan\Type\MixedType(\false), new \PHPStan\Type\MixedType(\true)), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo')], [new \PHPStan\Type\IntegerType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo'), new \PHPStan\Type\Constant\ConstantStringType('bar')], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType()]), \PHPStan\TrinaryLogic::createYes()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo'), new \PHPStan\Type\Constant\ConstantStringType('bar')], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo')], [new \PHPStan\Type\IntegerType()]), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo'), new \PHPStan\Type\Constant\ConstantStringType('bar')], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType()], 2), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo'), new \PHPStan\Type\Constant\ConstantStringType('bar')], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType()], 2, [0]), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createNo()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo'), new \PHPStan\Type\Constant\ConstantStringType('bar')], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType()], 2, [0, 1]), new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createMaybe()]);
        (yield [new \PHPStan\Type\Constant\ConstantArrayType([], []), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('foo'), new \PHPStan\Type\Constant\ConstantStringType('bar')], [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\IntegerType()], 2, [0, 1]), \PHPStan\TrinaryLogic::createMaybe()]);
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param ConstantArrayType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\Constant\ConstantArrayType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataInferTemplateTypes() : array
    {
        $templateType = static function (string $name) : Type {
            return \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), $name, new \PHPStan\Type\MixedType(), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return ['receive constant array' => [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b')], [new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b')], [$templateType('T'), $templateType('U')]), ['T' => 'string', 'U' => 'int']], 'receive constant array int' => [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)], [$templateType('T'), $templateType('U')]), ['T' => 'string', 'U' => 'int']], 'receive incompatible constant array' => [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('c')], [new \PHPStan\Type\StringType()]), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b')], [$templateType('T'), $templateType('U')]), []], 'receive mixed' => [new \PHPStan\Type\MixedType(), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a')], [$templateType('T')]), []], 'receive array' => [new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\StringType()), new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a')], [$templateType('T')]), ['T' => 'string']]];
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
    /**
     * @dataProvider dataIsCallable
     */
    public function testIsCallable(\PHPStan\Type\Constant\ConstantArrayType $type, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isCallable();
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isCallable()', $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsCallable() : iterable
    {
        (yield 'zero items' => [new \PHPStan\Type\Constant\ConstantArrayType([], []), \PHPStan\TrinaryLogic::createNo()]);
        (yield 'function name' => [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0)], [new \PHPStan\Type\Constant\ConstantStringType('strlen')]), \PHPStan\TrinaryLogic::createNo()]);
        (yield 'existing static method' => [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantStringType(\Closure::class, \true), new \PHPStan\Type\Constant\ConstantStringType('bind')]), \PHPStan\TrinaryLogic::createYes()]);
        (yield 'non-existing static method' => [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantStringType(\Closure::class, \true), new \PHPStan\Type\Constant\ConstantStringType('foobar')]), \PHPStan\TrinaryLogic::createNo()]);
        (yield 'existing static method but not a class string' => [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantIntegerType(0), new \PHPStan\Type\Constant\ConstantIntegerType(1)], [new \PHPStan\Type\Constant\ConstantStringType('Closure'), new \PHPStan\Type\Constant\ConstantStringType('bind')]), \PHPStan\TrinaryLogic::createYes()]);
        (yield 'existing static method but with string keys' => [new \PHPStan\Type\Constant\ConstantArrayType([new \PHPStan\Type\Constant\ConstantStringType('a'), new \PHPStan\Type\Constant\ConstantStringType('b')], [new \PHPStan\Type\Constant\ConstantStringType(\Closure::class, \true), new \PHPStan\Type\Constant\ConstantStringType('bind')]), \PHPStan\TrinaryLogic::createNo()]);
    }
}
