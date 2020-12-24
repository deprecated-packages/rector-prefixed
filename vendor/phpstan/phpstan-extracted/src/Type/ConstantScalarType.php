<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

interface ConstantScalarType extends \_PhpScoper0a6b37af0871\PHPStan\Type\ConstantType
{
    /**
     * @return int|float|string|bool|null
     */
    public function getValue();
}
