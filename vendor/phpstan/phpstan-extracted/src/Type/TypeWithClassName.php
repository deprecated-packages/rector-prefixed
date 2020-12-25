<?php

declare (strict_types=1);
namespace PHPStan\Type;

interface TypeWithClassName extends \PHPStan\Type\Type
{
    public function getClassName() : string;
    public function getAncestorWithClassName(string $className) : ?\PHPStan\Type\ObjectType;
}
