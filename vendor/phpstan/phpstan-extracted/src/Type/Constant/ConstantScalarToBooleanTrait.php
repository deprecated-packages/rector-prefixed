<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type\Constant;

use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
trait ConstantScalarToBooleanTrait
{
    public function toBoolean() : \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType
    {
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantBooleanType((bool) $this->value);
    }
}
