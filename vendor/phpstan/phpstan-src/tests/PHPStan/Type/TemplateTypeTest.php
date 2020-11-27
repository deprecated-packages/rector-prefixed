<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\TemplateType;
use PHPStan\Type\Generic\TemplateTypeFactory;
use PHPStan\Type\Generic\TemplateTypeHelper;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\Generic\TemplateTypeVariance;
class TemplateTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataAccepts() : array
    {
        $templateType = static function (string $name, ?\PHPStan\Type\Type $bound, ?string $functionName = null) : Type {
            return \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction($functionName ?? '_'), $name, $bound, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return [[$templateType('T', new \PHPStan\Type\ObjectType('DateTime')), new \PHPStan\Type\ObjectType('DateTime'), \PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createNo()], [$templateType('T', new \PHPStan\Type\ObjectType('DateTimeInterface')), new \PHPStan\Type\ObjectType('DateTime'), \PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createNo()], [$templateType('T', new \PHPStan\Type\ObjectType('DateTime')), $templateType('T', new \PHPStan\Type\ObjectType('DateTime')), \PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createYes()], [$templateType('T', new \PHPStan\Type\ObjectType('DateTime'), 'a'), $templateType('T', new \PHPStan\Type\ObjectType('DateTime'), 'b'), \PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createNo()], [$templateType('T', null), new \PHPStan\Type\MixedType(), \PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createYes()], [$templateType('T', null), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectWithoutClassType(), $templateType('T', null)]), \PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataAccepts
     */
    public function testAccepts(\PHPStan\Type\Type $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedAccept, \PHPStan\TrinaryLogic $expectedAcceptArg) : void
    {
        \assert($type instanceof \PHPStan\Type\Generic\TemplateType);
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedAccept->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
        $type = $type->toArgument();
        $actualResult = $type->accepts($otherType, \true);
        $this->assertSame($expectedAcceptArg->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s) (Argument strategy)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataIsSuperTypeOf() : array
    {
        $templateType = static function (string $name, ?\PHPStan\Type\Type $bound, ?string $functionName = null) : Type {
            return \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction($functionName ?? '_'), $name, $bound, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return [0 => [
            $templateType('T', new \PHPStan\Type\ObjectType('DateTime')),
            new \PHPStan\Type\ObjectType('DateTime'),
            \PHPStan\TrinaryLogic::createMaybe(),
            // (T of DateTime) isSuperTypeTo DateTime
            \PHPStan\TrinaryLogic::createYes(),
        ], 1 => [$templateType('T', new \PHPStan\Type\ObjectType('DateTime')), $templateType('T', new \PHPStan\Type\ObjectType('DateTime')), \PHPStan\TrinaryLogic::createYes(), \PHPStan\TrinaryLogic::createYes()], 2 => [$templateType('T', new \PHPStan\Type\ObjectType('DateTime'), 'a'), $templateType('T', new \PHPStan\Type\ObjectType('DateTime'), 'b'), \PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createMaybe()], 3 => [
            $templateType('T', new \PHPStan\Type\ObjectType('DateTime')),
            new \PHPStan\Type\StringType(),
            \PHPStan\TrinaryLogic::createNo(),
            // (T of DateTime) isSuperTypeTo string
            \PHPStan\TrinaryLogic::createNo(),
        ], 4 => [
            $templateType('T', new \PHPStan\Type\ObjectType('DateTime')),
            new \PHPStan\Type\ObjectType('DateTimeInterface'),
            \PHPStan\TrinaryLogic::createMaybe(),
            // (T of DateTime) isSuperTypeTo DateTimeInterface
            \PHPStan\TrinaryLogic::createYes(),
        ], 5 => [
            $templateType('T', new \PHPStan\Type\ObjectType('DateTime')),
            $templateType('T', new \PHPStan\Type\ObjectType('DateTimeInterface')),
            \PHPStan\TrinaryLogic::createMaybe(),
            // (T of DateTime) isSuperTypeTo (T of DateTimeInterface)
            \PHPStan\TrinaryLogic::createMaybe(),
        ], 6 => [
            $templateType('T', new \PHPStan\Type\ObjectType('DateTime')),
            new \PHPStan\Type\NullType(),
            \PHPStan\TrinaryLogic::createNo(),
            // (T of DateTime) isSuperTypeTo null
            \PHPStan\TrinaryLogic::createNo(),
        ], 7 => [
            $templateType('T', new \PHPStan\Type\ObjectType('DateTime')),
            new \PHPStan\Type\UnionType([new \PHPStan\Type\NullType(), new \PHPStan\Type\ObjectType('DateTime')]),
            \PHPStan\TrinaryLogic::createMaybe(),
            // (T of DateTime) isSuperTypeTo (DateTime|null)
            \PHPStan\TrinaryLogic::createYes(),
        ], 8 => [
            $templateType('T', new \PHPStan\Type\ObjectType('DateTimeInterface')),
            new \PHPStan\Type\UnionType([new \PHPStan\Type\NullType(), new \PHPStan\Type\ObjectType('DateTime')]),
            \PHPStan\TrinaryLogic::createMaybe(),
            // (T of DateTimeInterface) isSuperTypeTo (DateTime|null)
            \PHPStan\TrinaryLogic::createMaybe(),
        ], 9 => [
            $templateType('T', new \PHPStan\Type\ObjectType('DateTime')),
            new \PHPStan\Type\UnionType([new \PHPStan\Type\NullType(), new \PHPStan\Type\ObjectType('DateTimeInterface')]),
            \PHPStan\TrinaryLogic::createMaybe(),
            // (T of DateTime) isSuperTypeTo (DateTimeInterface|null)
            \PHPStan\TrinaryLogic::createYes(),
        ], 10 => [
            $templateType('T', null),
            new \PHPStan\Type\MixedType(\true),
            \PHPStan\TrinaryLogic::createMaybe(),
            // T isSuperTypeTo mixed
            \PHPStan\TrinaryLogic::createYes(),
        ], 11 => [
            $templateType('T', null),
            new \PHPStan\Type\ObjectType(\DateTimeInterface::class),
            \PHPStan\TrinaryLogic::createMaybe(),
            // T isSuperTypeTo DateTimeInterface
            \PHPStan\TrinaryLogic::createMaybe(),
        ], 12 => [$templateType('T', new \PHPStan\Type\ObjectWithoutClassType()), new \PHPStan\Type\ObjectWithoutClassType(), \PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createYes()], 13 => [$templateType('T', new \PHPStan\Type\ObjectWithoutClassType()), new \PHPStan\Type\ObjectType(\DateTimeInterface::class), \PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createMaybe()], 14 => [$templateType('T', new \PHPStan\Type\ObjectType(\Throwable::class)), new \PHPStan\Type\ObjectType(\Exception::class), \PHPStan\TrinaryLogic::createMaybe(), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     */
    public function testIsSuperTypeOf(\PHPStan\Type\Type $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedIsSuperType, \PHPStan\TrinaryLogic $expectedIsSuperTypeInverse) : void
    {
        \assert($type instanceof \PHPStan\Type\Generic\TemplateType);
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedIsSuperType->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
        $actualResult = $otherType->isSuperTypeOf($type);
        $this->assertSame($expectedIsSuperTypeInverse->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $otherType->describe(\PHPStan\Type\VerbosityLevel::precise()), $type->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    /** @return array<string,array{Type,Type,array<string,string>}> */
    public function dataInferTemplateTypes() : array
    {
        $templateType = static function (string $name, ?\PHPStan\Type\Type $bound = null, ?string $functionName = null) : Type {
            return \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction($functionName ?? '_'), $name, $bound, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return ['simple' => [new \PHPStan\Type\IntegerType(), $templateType('T'), ['T' => 'int']], 'object' => [new \PHPStan\Type\ObjectType(\DateTime::class), $templateType('T'), ['T' => 'DateTime']], 'object with bound' => [new \PHPStan\Type\ObjectType(\DateTime::class), $templateType('T', new \PHPStan\Type\ObjectType(\DateTimeInterface::class)), ['T' => 'DateTime']], 'wrong object with bound' => [new \PHPStan\Type\ObjectType(\stdClass::class), $templateType('T', new \PHPStan\Type\ObjectType(\DateTimeInterface::class)), []], 'template type' => [\PHPStan\Type\Generic\TemplateTypeHelper::toArgument($templateType('T', new \PHPStan\Type\ObjectType(\DateTimeInterface::class))), $templateType('T', new \PHPStan\Type\ObjectType(\DateTimeInterface::class)), ['T' => 'T of DateTimeInterface (function _(), argument)']], 'foreign template type' => [\PHPStan\Type\Generic\TemplateTypeHelper::toArgument($templateType('T', new \PHPStan\Type\ObjectType(\DateTimeInterface::class), 'a')), $templateType('T', new \PHPStan\Type\ObjectType(\DateTimeInterface::class), 'b'), ['T' => 'T of DateTimeInterface (function a(), argument)']], 'foreign template type, imcompatible bound' => [\PHPStan\Type\Generic\TemplateTypeHelper::toArgument($templateType('T', new \PHPStan\Type\ObjectType(\stdClass::class), 'a')), $templateType('T', new \PHPStan\Type\ObjectType(\DateTime::class), 'b'), []]];
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
