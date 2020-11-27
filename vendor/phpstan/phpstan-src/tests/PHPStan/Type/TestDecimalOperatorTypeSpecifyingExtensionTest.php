<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Fixture\TestDecimal;
use _PhpScoper006a73f0e455\PHPUnit\Framework\TestCase;
class TestDecimalOperatorTypeSpecifyingExtensionTest extends \_PhpScoper006a73f0e455\PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataSigilAndSidesProvider
     */
    public function testSupportsMatchingSigilsAndSides(string $sigil, \PHPStan\Type\Type $leftType, \PHPStan\Type\Type $rightType) : void
    {
        $extension = new \PHPStan\Type\TestDecimalOperatorTypeSpecifyingExtension();
        $result = $extension->isOperatorSupported($sigil, $leftType, $rightType);
        self::assertTrue($result);
    }
    public function dataSigilAndSidesProvider() : iterable
    {
        (yield '+' => ['+', new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class), new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class)]);
        (yield '-' => ['-', new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class), new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class)]);
        (yield '*' => ['*', new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class), new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class)]);
        (yield '/' => ['/', new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class), new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class)]);
    }
    /**
     * @dataProvider dataNotMatchingSidesProvider
     */
    public function testNotSupportsNotMatchingSides(string $sigil, \PHPStan\Type\Type $leftType, \PHPStan\Type\Type $rightType) : void
    {
        $extension = new \PHPStan\Type\TestDecimalOperatorTypeSpecifyingExtension();
        $result = $extension->isOperatorSupported($sigil, $leftType, $rightType);
        self::assertFalse($result);
    }
    public function dataNotMatchingSidesProvider() : iterable
    {
        (yield 'left' => ['+', new \PHPStan\Type\ObjectType(\stdClass::class), new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class)]);
        (yield 'right' => ['+', new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class), new \PHPStan\Type\ObjectType(\stdClass::class)]);
    }
}
