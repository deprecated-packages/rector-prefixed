<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Type;

interface TypeWithClassName extends \_PhpScopere8e811afab72\PHPStan\Type\Type
{
    public function getClassName() : string;
    public function getAncestorWithClassName(string $className) : ?\_PhpScopere8e811afab72\PHPStan\Type\ObjectType;
}
