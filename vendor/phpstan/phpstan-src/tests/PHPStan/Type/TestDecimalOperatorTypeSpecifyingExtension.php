<?php

declare (strict_types=1);
namespace PHPStan\Type;

use PHPStan\Fixture\TestDecimal;
final class TestDecimalOperatorTypeSpecifyingExtension implements \PHPStan\Type\OperatorTypeSpecifyingExtension
{
    public function isOperatorSupported(string $operatorSigil, \PHPStan\Type\Type $leftSide, \PHPStan\Type\Type $rightSide) : bool
    {
        return \in_array($operatorSigil, ['-', '+', '*', '/'], \true) && $leftSide->isSuperTypeOf(new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class))->yes() && $rightSide->isSuperTypeOf(new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class))->yes();
    }
    public function specifyType(string $operatorSigil, \PHPStan\Type\Type $leftSide, \PHPStan\Type\Type $rightSide) : \PHPStan\Type\Type
    {
        return new \PHPStan\Type\ObjectType(\PHPStan\Fixture\TestDecimal::class);
    }
}
