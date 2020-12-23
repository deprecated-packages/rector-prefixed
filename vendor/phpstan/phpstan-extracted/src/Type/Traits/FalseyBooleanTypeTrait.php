<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type\Traits;

use _PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType;
trait FalseyBooleanTypeTrait
{
    public function toBoolean() : \_PhpScoper0a2ac50786fa\PHPStan\Type\BooleanType
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
}
