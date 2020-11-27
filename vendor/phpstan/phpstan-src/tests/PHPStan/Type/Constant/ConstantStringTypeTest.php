<?php

declare (strict_types=1);
namespace PHPStan\Type\Constant;

use PHPStan\Testing\TestCase;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Generic\GenericClassStringType;
use PHPStan\Type\Generic\TemplateTypeFactory;
use PHPStan\Type\Generic\TemplateTypeScope;
use PHPStan\Type\Generic\TemplateTypeVariance;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StaticType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
class ConstantStringTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataIsSuperTypeOf() : array
    {
        return [0 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), \PHPStan\TrinaryLogic::createMaybe()], 1 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Throwable::class)), \PHPStan\TrinaryLogic::createMaybe()], 2 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\InvalidArgumentException::class)), \PHPStan\TrinaryLogic::createNo()], 3 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\stdClass::class)), \PHPStan\TrinaryLogic::createNo()], 4 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), \PHPStan\TrinaryLogic::createYes()], 5 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Constant\ConstantStringType(\InvalidArgumentException::class), \PHPStan\TrinaryLogic::createNo()], 6 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\Exception::class)), \PHPStan\TrinaryLogic::createMaybe()], 7 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\ObjectType(\stdClass::class)), \PHPStan\TrinaryLogic::createNo()], 8 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', null, \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), \PHPStan\TrinaryLogic::createMaybe()], 9 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', new \PHPStan\Type\ObjectType(\Exception::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), \PHPStan\TrinaryLogic::createMaybe()], 10 => [new \PHPStan\Type\Constant\ConstantStringType(\InvalidArgumentException::class), new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', new \PHPStan\Type\ObjectType(\Exception::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), \PHPStan\TrinaryLogic::createMaybe()], 11 => [new \PHPStan\Type\Constant\ConstantStringType(\Throwable::class), new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', new \PHPStan\Type\ObjectType(\Exception::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), \PHPStan\TrinaryLogic::createNo()], 12 => [new \PHPStan\Type\Constant\ConstantStringType(\stdClass::class), new \PHPStan\Type\Generic\GenericClassStringType(\PHPStan\Type\Generic\TemplateTypeFactory::create(\PHPStan\Type\Generic\TemplateTypeScope::createWithFunction('foo'), 'T', new \PHPStan\Type\ObjectType(\Exception::class), \PHPStan\Type\Generic\TemplateTypeVariance::createInvariant())), \PHPStan\TrinaryLogic::createNo()], 13 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\StaticType(\Exception::class)), \PHPStan\TrinaryLogic::createMaybe()], 14 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\StaticType(\InvalidArgumentException::class)), \PHPStan\TrinaryLogic::createNo()], 15 => [new \PHPStan\Type\Constant\ConstantStringType(\Exception::class), new \PHPStan\Type\Generic\GenericClassStringType(new \PHPStan\Type\StaticType(\Throwable::class)), \PHPStan\TrinaryLogic::createMaybe()]];
    }
    /**
     * @dataProvider dataIsSuperTypeOf
     */
    public function testIsSuperTypeOf(\PHPStan\Type\Constant\ConstantStringType $type, \PHPStan\Type\Type $otherType, \PHPStan\TrinaryLogic $expectedResult) : void
    {
        $actualResult = $type->isSuperTypeOf($otherType);
        $this->assertSame($expectedResult->describe(), $actualResult->describe(), \sprintf('%s -> isSuperTypeOf(%s)', $type->describe(\PHPStan\Type\VerbosityLevel::precise()), $otherType->describe(\PHPStan\Type\VerbosityLevel::precise())));
    }
    public function testGeneralize() : void
    {
        $this->assertSame('string', (new \PHPStan\Type\Constant\ConstantStringType('NonexistentClass'))->generalize()->describe(\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertSame('string', (new \PHPStan\Type\Constant\ConstantStringType(\stdClass::class))->generalize()->describe(\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertSame('class-string', (new \PHPStan\Type\Constant\ConstantStringType(\stdClass::class, \true))->generalize()->describe(\PHPStan\Type\VerbosityLevel::precise()));
        $this->assertSame('class-string', (new \PHPStan\Type\Constant\ConstantStringType('NonexistentClass', \true))->generalize()->describe(\PHPStan\Type\VerbosityLevel::precise()));
    }
    public function testTextInvalidEncoding() : void
    {
        $this->assertSame("'ÃLorem ipsum dolor sâ€¦'", (new \PHPStan\Type\Constant\ConstantStringType("ÃLorem ipsum dolor sit"))->describe(\PHPStan\Type\VerbosityLevel::value()));
    }
    public function testShortTextInvalidEncoding() : void
    {
        $this->assertSame("'ÃLorem ipsum dolor'", (new \PHPStan\Type\Constant\ConstantStringType("ÃLorem ipsum dolor"))->describe(\PHPStan\Type\VerbosityLevel::value()));
    }
}
