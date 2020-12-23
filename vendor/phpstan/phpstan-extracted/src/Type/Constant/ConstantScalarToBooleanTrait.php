<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Constant;

use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
trait ConstantScalarToBooleanTrait
{
    public function toBoolean() : \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType((bool) $this->value);
    }
}
