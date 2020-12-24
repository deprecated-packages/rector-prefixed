<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

interface TypeWithClassName extends \_PhpScoper0a6b37af0871\PHPStan\Type\Type
{
    public function getClassName() : string;
    public function getAncestorWithClassName(string $className) : ?\_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
}
