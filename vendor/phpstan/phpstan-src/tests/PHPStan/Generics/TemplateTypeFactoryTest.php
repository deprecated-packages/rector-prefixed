<?php

declare (strict_types=1);
namespace PHPStan\Generics;

use PHPStan\Type\ErrorType;
use PHPStan\Type\Generic\TemplateType;
use PHPStan\Type\Generic\TemplateTypeFactory;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use PHPStan\Type\VerbosityLevel;
class TemplateTypeFactoryTest extends \PHPStan\Testing\TestCase
{
    /** @return array<array{?Type, Type}> */
    public function dataCreate() : array
    {
        return [[new \PHPStan\Type\ObjectType('DateTime'), new \PHPStan\Type\ObjectType('DateTime')], [new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType()], [null, new \PHPStan\Type\MixedType()], [new \PHPStan\Type\StringType(), new \PHPStan\Type\MixedType()], [new \PHPStan\Type\ErrorType(), new \PHPStan\Type\MixedType()], [\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a'), 'U', null, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant()), new \PHPStan\Type\MixedType()], [new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()]), new \PHPStan\Type\MixedType()]];
    }
    /**
     * @dataProvider dataCreate
     */
    public function testCreate(?\PHPStan\Type\Type $bound, \PHPStan\Type\Type $expectedBound) : void
    {
        $scope = \PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('a');
        $templateType = \PHPStan\Type\Generic\TemplateTypeFactory::create($scope, 'T', $bound, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant());
        $this->assertInstanceOf(\PHPStan\Type\Generic\TemplateType::class, $templateType);
        $this->assertTrue($expectedBound->equals($templateType->getBound()), \sprintf('%s -> equals(%s)', $expectedBound->describe(\PHPStan\Type\VerbosityLevel::precise()), $templateType->getBound()->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
}
