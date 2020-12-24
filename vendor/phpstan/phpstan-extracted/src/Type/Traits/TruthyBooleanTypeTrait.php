<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type\Traits;

use _PhpScoper0a6b37af0871\PHPStan\Type\BooleanType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType;
trait TruthyBooleanTypeTrait
{
    public function toBoolean() : \_PhpScoper0a6b37af0871\PHPStan\Type\BooleanType
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Type\Constant\ConstantBooleanType(\true);
    }
}
