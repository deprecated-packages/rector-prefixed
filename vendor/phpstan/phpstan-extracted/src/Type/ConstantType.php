<?php

declare (strict_types=1);
namespace PHPStan\Type;

interface ConstantType extends \PHPStan\Type\Type
{
    public function generalize() : \PHPStan\Type\Type;
}
