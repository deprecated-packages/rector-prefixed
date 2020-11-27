<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Reflection\Native\NativeParameterReflection;
use PHPStan\Reflection\PassedByReference;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Accessory\HasMethodType;
use PHPStan\Type\Generic\TemplateTypeFactory;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\Generic\TemplateTypeVariance;
class CallableTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [[new \PHPStan\Type\CallableType(), new \PHPStan\Type\ClosureType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\Accessory\HasMethodType('format'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\Accessory\HasMethodType('__invoke'), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     * @param CallableType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSuperTypeOf(\PHPStan\Type\CallableType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSubTypeOf() : array
    {
        return [[new \PHPStan\Type\CallableType(), new \PHPStan\Type\CallableType(), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\StringType(), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\IntegerType(), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\UnionType([new \PHPStan\Type\CallableType(), new \PHPStan\Type\NullType()]), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\NullType()]), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\NullType()]), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\CallableType()]), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\IntegerType()]), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\CallableType(), new \PHPStan\Type\StringType()]), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\CallableType(), new \PHPStan\Type\ObjectType('Unknown')]), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\Accessory\HasMethodType('foo'), \PHPStan\TrinaryLogic::createMaybe()], [new \PHPStan\Type\CallableType(), new \PHPStan\Type\Accessory\HasMethodType('__invoke'), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param CallableType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOf(\PHPStan\Type\CallableType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSubTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSubTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    /**
     * @dataProvider dataIsSubTypeOf
     * @param CallableType $type
     * @param Type $otherType
     * @param TrinaryLogic $expectedResult
     */
    public function testIsSubTypeOfInversed(\PHPStan\Type\CallableType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $otherType->isSuperTypeOf($type);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $otherType->describe(\PHPStan\Type\VerbosityLevel::precise()), $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataInferTemplateTypes() : array
    {
        $param = static function (\PHPStan\Type\Type $type) : NativeParameterReflection {
            return new \PHPStan\Reflection\Native\NativeParameterReflection('', \false, $type, \PHPStan\Reflection\PassedByReference::createNo(), \false, null);
        };
        $templateType = static function (string $name) : Type {
            return \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), $name, new \PHPStan\Type\MixedType(), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return ['template param' => [new \PHPStan\Type\CallableType([$param(new \PHPStan\Type\StringType())], new \PHPStan\Type\IntegerType()), new \PHPStan\Type\CallableType([$param($templateType('T'))], new \PHPStan\Type\IntegerType()), ['T' => 'string']], 'template return' => [new \PHPStan\Type\CallableType([$param(new \PHPStan\Type\StringType())], new \PHPStan\Type\IntegerType()), new \PHPStan\Type\CallableType([$param(new \PHPStan\Type\StringType())], $templateType('T')), ['T' => 'int']], 'multiple templates' => [new \PHPStan\Type\CallableType([$param(new \PHPStan\Type\StringType()), $param(new \PHPStan\Type\ObjectType('DateTime'))], new \PHPStan\Type\IntegerType()), new \PHPStan\Type\CallableType([$param(new \PHPStan\Type\StringType()), $param($templateType('A'))], $templateType('B')), ['A' => 'DateTime', 'B' => 'int']], 'receive union' => [new \PHPStan\Type\UnionType([new \PHPStan\Type\NullType(), new \PHPStan\Type\CallableType([$param(new \PHPStan\Type\StringType()), $param(new \PHPStan\Type\ObjectType('DateTime'))], new \PHPStan\Type\IntegerType())]), new \PHPStan\Type\CallableType([$param(new \PHPStan\Type\StringType()), $param($templateType('A'))], $templateType('B')), ['A' => 'DateTime', 'B' => 'int']], 'receive non-accepted' => [new \PHPStan\Type\NullType(), new \PHPStan\Type\CallableType([$param(new \PHPStan\Type\StringType()), $param($templateType('A'))], $templateType('B')), []]];
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
    public function dataAccepts() : array
    {
        return [[new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, new \PHPStan\Type\MixedType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('bar', \true, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('bar', \true, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('bar', \false, new \PHPStan\Type\StringType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\CallableType([new \PHPStan\Reflection\Native\NativeParameterReflection('foo', \false, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null), new \PHPStan\Reflection\Native\NativeParameterReflection('bar', \true, new \PHPStan\Type\IntegerType(), \PHPStan\Reflection\PassedByReference::createNo(), \false, null)], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createNo()], [new \PHPStan\Type\CallableType([], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\CallableType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\CallableType([], new \PHPStan\Type\IntegerType(), \false), new \PHPStan\Type\CallableType([], new \PHPStan\Type\MixedType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\CallableType([], new \PHPStan\Type\MixedType(), \false), new \PHPStan\Type\CallableType([], new \PHPStan\Type\IntegerType(), \false), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\CallableType(), \PHPStan\Type\TypeCombinator::intersect(new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()), new \PHPStan\Type\CallableType()), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataAccepts
     * @param \PHPStan\Type\CallableType $type
     * @param Type $acceptedType
     * @param TrinaryLogic $expectedResult
     */
    public function testAccepts(\PHPStan\Type\CallableType $type, \PHPStan\Type\Type $acceptedType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $this->assertSame($expectedResult->describe(), $type->accepts($acceptedType, \true)->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $acceptedType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
}
