<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Traits;

use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
trait UndecidedBooleanTypeTrait
{
    public function toBoolean() : \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType();
    }
}
