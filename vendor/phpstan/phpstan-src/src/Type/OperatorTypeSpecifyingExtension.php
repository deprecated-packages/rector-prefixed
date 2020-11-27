<?php

declare (strict_types=1);
namespace PHPStan\Type;

interface OperatorTypeSpecifyingExtension
{
    public function isOperatorSupported(string $operatorSigil, \PHPStan\Type\Type $leftSide, \PHPStan\Type\Type $rightSide) : bool;
    public function specifyType(string $operatorSigil, \PHPStan\Type\Type $leftSide, \PHPStan\Type\Type $rightSide) : \PHPStan\Type\Type;
}
