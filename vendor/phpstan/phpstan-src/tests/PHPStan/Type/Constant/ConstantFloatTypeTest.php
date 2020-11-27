<?php

declare (strict_types=1);
namespace PHPStan\Type\Constant;

use PHPStan\Type\VerbosityLevel;
class ConstantFloatTypeTest extends \PHPStan\Testing\TestCase
{
    public function dataDescribe() : array
    {
        return [[new \PHPStan\Type\Constant\ConstantFloatType(2.0), '2.0'], [new \PHPStan\Type\Constant\ConstantFloatType(2.0123), '2.0123'], [new \PHPStan\Type\Constant\ConstantFloatType(1.2000000992884E-10), '1.2000000992884E-10'], [new \PHPStan\Type\Constant\ConstantFloatType(1.2 * 1.4), '1.68']];
    }
    /**
     * @dataProvider dataDescribe
     * @param ConstantFloatType $type
     * @param string $expectedDescription
     */
    public function testDescribe(\PHPStan\Type\Constant\ConstantFloatType $type, string $expectedDescription) : void
    {
        $this->assertSame($expectedDescription, $type->describe(\PHPStan\Type\VerbosityLevel::precise()));
    }
}
