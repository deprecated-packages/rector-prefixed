<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

interface OperatorTypeSpecifyingExtension
{
    public function isOperatorSupported(string $operatorSigil, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $leftSide, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $rightSide) : bool;
    public function specifyType(string $operatorSigil, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $leftSide, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $rightSide) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
}
