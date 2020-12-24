<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

interface TypeWithClassName extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
{
    public function getClassName() : string;
    public function getAncestorWithClassName(string $className) : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
}
