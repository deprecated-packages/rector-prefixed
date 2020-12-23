<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

interface TypeWithClassName extends \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
{
    public function getClassName() : string;
    public function getAncestorWithClassName(string $className) : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
}
