<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

interface ConstantScalarType extends \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantType
{
    /**
     * @return int|float|string|bool|null
     */
    public function getValue();
}
