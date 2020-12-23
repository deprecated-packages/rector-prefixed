<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

interface OperatorTypeSpecifyingExtension
{
    public function isOperatorSupported(string $operatorSigil, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $leftSide, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $rightSide) : bool;
    public function specifyType(string $operatorSigil, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $leftSide, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $rightSide) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
}
