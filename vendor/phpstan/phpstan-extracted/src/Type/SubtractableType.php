<?php

declare (strict_types=1);
namespace PHPStan\Type;

interface SubtractableType extends \PHPStan\Type\Type
{
    public function subtract(\PHPStan\Type\Type $type) : \PHPStan\Type\Type;
    public function getTypeWithoutSubtractedType() : \PHPStan\Type\Type;
    public function changeSubtractedType(?\PHPStan\Type\Type $subtractedType) : \PHPStan\Type\Type;
    public function getSubtractedType() : ?\PHPStan\Type\Type;
}
