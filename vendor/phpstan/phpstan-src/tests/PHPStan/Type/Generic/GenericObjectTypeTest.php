<?php

declare (strict_types=1);
namespace PHPStan\Type\Generic;

use PHPStan\TrinaryLogic;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Test\A;
use PHPStan\Type\Test\B;
use PHPStan\Type\Test\C;
use PHPStan\Type\Test\D;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
class GenericObjectTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return ['equal type' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTime')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createYes()], 'sub-class with static @extends with same type args' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTime')]), new \PHPStan\Type\ObjectType(\PHPStan\Type\Test\A\AOfDateTime::class), \PHPStan\TrinaryLogic::createYes()], 'sub-class with @extends with same type args' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTime')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\SubA::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createYes()], 'same class, different type args' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTimeInterface')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createNo()], 'same class, one naked' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTimeInterface')]), new \PHPStan\Type\ObjectType(\PHPStan\Type\Test\A\A::class), \PHPStan\TrinaryLogic::createMaybe()], 'implementation with @extends with same type args' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\B\I::class, [new \PHPStan\Type\ObjectType('DateTime')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\B\IImpl::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createYes()], 'implementation with @extends with different type args' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\B\I::class, [new \PHPStan\Type\ObjectType('DateTimeInteface')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\B\IImpl::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createNo()], 'invariant with equals types' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\C\Invariant::class, [new \PHPStan\Type\ObjectType('DateTime')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\C\Invariant::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createYes()], 'invariant with sub type' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\C\Invariant::class, [new \PHPStan\Type\ObjectType('DateTimeInterface')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\C\Invariant::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createNo()], 'invariant with super type' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\C\Invariant::class, [new \PHPStan\Type\ObjectType('DateTime')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\C\Invariant::class, [new \PHPStan\Type\ObjectType('DateTimeInterface')]), \PHPStan\TrinaryLogic::createNo()], 'covariant with equals types' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\C\Covariant::class, [new \PHPStan\Type\ObjectType('DateTime')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\C\Covariant::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createYes()], 'covariant with sub type' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\C\Covariant::class, [new \PHPStan\Type\ObjectType('DateTimeInterface')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\C\Covariant::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createYes()], 'covariant with super type' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\C\Covariant::class, [new \PHPStan\Type\ObjectType('DateTime')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\C\Covariant::class, [new \PHPStan\Type\ObjectType('DateTimeInterface')]), \PHPStan\TrinaryLogic::createNo()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     */
    public function testIsSuperTypeOf(\PHPStan\Type\Type $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function dataAccepts() : array
    {
        return ['equal type' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTime')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createYes()], 'sub-class with static @extends with same type args' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTime')]), new \PHPStan\Type\ObjectType(\PHPStan\Type\Test\A\AOfDateTime::class), \PHPStan\TrinaryLogic::createYes()], 'sub-class with @extends with same type args' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTime')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\SubA::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createYes()], 'same class, different type args' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTimeInterface')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createNo()], 'same class, one naked' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType('DateTimeInterface')]), new \PHPStan\Type\ObjectType(\PHPStan\Type\Test\A\A::class), \PHPStan\TrinaryLogic::createYes()], 'implementation with @extends with same type args' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\B\I::class, [new \PHPStan\Type\ObjectType('DateTime')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\B\IImpl::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createYes()], 'implementation with @extends with different type args' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\B\I::class, [new \PHPStan\Type\ObjectType('DateTimeInteface')]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\B\IImpl::class, [new \PHPStan\Type\ObjectType('DateTime')]), \PHPStan\TrinaryLogic::createNo()], 'generic object accepts normal object of same type' => [new \PHPStan\Type\Generic\GenericObjectType(\Traversable::class, [new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\ObjectType('DateTimeInteface')]), new \PHPStan\Type\ObjectType(\Traversable::class), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\Generic\GenericObjectType(\Iterator::class, [new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\MixedType(\true)]), new \PHPStan\Type\ObjectType(\Iterator::class), \PHPStan\TrinaryLogic::createYes()], [new \PHPStan\Type\Generic\GenericObjectType(\Iterator::class, [new \PHPStan\Type\MixedType(\true), new \PHPStan\Type\MixedType(\true)]), new \PHPStan\Type\IntersectionType([new \PHPStan\Type\ObjectType(\Iterator::class), new \PHPStan\Type\ObjectType(\DateTimeInterface::class)]), \PHPStan\TrinaryLogic::createYes()]];
    }
    /**
     * @dataProvider dataAccepts
     */
    public function testAccepts(\PHPStan\Type\Type $acceptingType, \PHPStan\Type\Type $acceptedType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $acceptingType->accepts($acceptedType, \true);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> accepts(%s)', $acceptingType->describe(\PHPStan\Type\VerbosityLevel::precise()), $acceptedType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    /** @return array<string,array{Type,Type,array<string,string>}> */
    public function dataInferTemplateTypes() : array
    {
        $templateType = static function (string $name, ?\PHPStan\Type\Type $bound = null) : Type {
            return \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), $name, $bound ?? new \PHPStan\Type\MixedType(), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        };
        return ['simple' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\ObjectType(\DateTime::class)]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [$templateType('T')]), ['T' => 'DateTime']], 'two types' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A2::class, [new \PHPStan\Type\ObjectType(\DateTime::class), new \PHPStan\Type\IntegerType()]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A2::class, [$templateType('K'), $templateType('V')]), ['K' => 'DateTime', 'V' => 'int']], 'union' => [new \PHPStan\Type\UnionType([new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A2::class, [new \PHPStan\Type\ObjectType(\DateTime::class), new \PHPStan\Type\IntegerType()]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A2::class, [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\ObjectType(\DateTime::class)])]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A2::class, [$templateType('K'), $templateType('V')]), ['K' => 'DateTime|int', 'V' => 'DateTime|int']], 'nested' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A2::class, [new \PHPStan\Type\ObjectType(\DateTime::class), new \PHPStan\Type\IntegerType()])]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A2::class, [$templateType('K'), $templateType('V')])]), ['K' => 'DateTime', 'V' => 'int']], 'missing type' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A2::class, [new \PHPStan\Type\ObjectType(\DateTime::class)]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A2::class, [$templateType('K', new \PHPStan\Type\ObjectType(\DateTimeInterface::class)), $templateType('V', new \PHPStan\Type\ObjectType(\DateTimeInterface::class))]), ['K' => 'DateTime']], 'wrong class' => [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\B\I::class, [new \PHPStan\Type\ObjectType(\DateTime::class)]), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [$templateType('T', new \PHPStan\Type\ObjectType(\DateTimeInterface::class))]), []], 'wrong type' => [new \PHPStan\Type\IntegerType(), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [$templateType('T', new \PHPStan\Type\ObjectType(\DateTimeInterface::class))]), []], 'sub type' => [new \PHPStan\Type\ObjectType(\PHPStan\Type\Test\A\AOfDateTime::class), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\A\A::class, [$templateType('T')]), ['T' => 'DateTime']]];
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
    /** @return array<array{TemplateTypeVariance,Type,array<TemplateTypeReference>}> */
    public function dataGetReferencedTypeArguments() : array
    {
        $templateType = static function (string $name, ?\PHPStan\Type\Type $bound = null) : TemplateType {
            $templateType = \PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), $name, $bound ?? new \PHPStan\Type\MixedType(), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
            if (!$templateType instanceof \PHPStan\Type\Generic\TemplateType) {
                throw new \PHPStan\ShouldNotHappenException();
            }
            return $templateType;
        };
        return ['param: Invariant<T>' => [\PHPStan\Type\Generic\TemplateTypeVariance::createContravariant(), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Invariant::class, [$templateType('T')]), [new \PHPStan\Type\Generic\TemplateTypeReference($templateType('T'), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())]], 'param: Out<T>' => [\PHPStan\Type\Generic\TemplateTypeVariance::createContravariant(), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [$templateType('T')]), [new \PHPStan\Type\Generic\TemplateTypeReference($templateType('T'), \PHPStan\Type\Generic\TemplateTypeVariance::createContravariant())]], 'param: Out<Out<T>>' => [\PHPStan\Type\Generic\TemplateTypeVariance::createContravariant(), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [$templateType('T')])]), [new \PHPStan\Type\Generic\TemplateTypeReference($templateType('T'), \PHPStan\Type\Generic\TemplateTypeVariance::createContravariant())]], 'param: Out<Out<Out<T>>>' => [\PHPStan\Type\Generic\TemplateTypeVariance::createContravariant(), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [$templateType('T')])])]), [new \PHPStan\Type\Generic\TemplateTypeReference($templateType('T'), \PHPStan\Type\Generic\TemplateTypeVariance::createContravariant())]], 'return: Invariant<T>' => [\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant(), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Invariant::class, [$templateType('T')]), [new \PHPStan\Type\Generic\TemplateTypeReference($templateType('T'), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())]], 'return: Out<T>' => [\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant(), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [$templateType('T')]), [new \PHPStan\Type\Generic\TemplateTypeReference($templateType('T'), \PHPStan\Type\Generic\TemplateTypeVariance::createCovariant())]], 'return: Out<Out<T>>' => [\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant(), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [$templateType('T')])]), [new \PHPStan\Type\Generic\TemplateTypeReference($templateType('T'), \PHPStan\Type\Generic\TemplateTypeVariance::createCovariant())]], 'return: Out<Out<Out<T>>>' => [\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant(), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [$templateType('T')])])]), [new \PHPStan\Type\Generic\TemplateTypeReference($templateType('T'), \PHPStan\Type\Generic\TemplateTypeVariance::createCovariant())]], 'return: Out<Invariant<T>>' => [\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant(), new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Out::class, [new \PHPStan\Type\Generic\GenericObjectType(\PHPStan\Type\Test\D\Invariant::class, [$templateType('T')])]), [new \PHPStan\Type\Generic\TemplateTypeReference($templateType('T'), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())]]];
    }
    /**
     * @dataProvider dataGetReferencedTypeArguments
     *
     * @param array<TemplateTypeReference> $expectedReferences
     */
    public function testGetReferencedTypeArguments(\PHPStan\Type\Generic\TemplateTypeVariance $positionVariance, \PHPStan\Type\Type $type, array $expectedReferences) : void
    {
        $result = [];
        foreach ($type->getReferencedTemplateTypes($positionVariance) as $r) {
            $result[] = $r;
        }
        $comparableResult = \array_map(static function (\PHPStan\Type\Generic\TemplateTypeReference $ref) : array {
            return ['type' => $ref->getType()->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), 'positionVariance' => $ref->getPositionVariance()->describe()];
        }, $result);
        $comparableExpect = \array_map(static function (\PHPStan\Type\Generic\TemplateTypeReference $ref) : array {
            return ['type' => $ref->getType()->describe(\PHPStan\Type\VerbosityLevel::typeOnly()), 'positionVariance' => $ref->getPositionVariance()->describe()];
        }, $expectedReferences);
        $this->assertSame($comparableExpect, $comparableResult);
    }
}
