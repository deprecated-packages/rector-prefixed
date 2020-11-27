<?php

declare (strict_types=1);
namespace PHPStan\Type;

interface ConstantScalarType extends \PHPStan\Type\ConstantType
{
    /**
     * @return int|float|string|bool|null
     */
    public function getValue();
}
