<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

interface OperatorTypeSpecifyingExtension
{
    public function isOperatorSupported(string $operatorSigil, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $leftSide, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $rightSide) : bool;
    public function specifyType(string $operatorSigil, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $leftSide, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $rightSide) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
}
