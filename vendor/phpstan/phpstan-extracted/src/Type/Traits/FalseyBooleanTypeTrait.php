<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Traits;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType;
trait FalseyBooleanTypeTrait
{
    public function toBoolean() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantBooleanType(\false);
    }
}
