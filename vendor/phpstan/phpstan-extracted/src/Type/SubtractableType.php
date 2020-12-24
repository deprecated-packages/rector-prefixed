<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Type;

interface SubtractableType extends \_PhpScoper0a6b37af0871\PHPStan\Type\Type
{
    public function subtract(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
    public function getTypeWithoutSubtractedType() : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
    public function changeSubtractedType(?\_PhpScoper0a6b37af0871\PHPStan\Type\Type $subtractedType) : \_PhpScoper0a6b37af0871\PHPStan\Type\Type;
    public function getSubtractedType() : ?\_PhpScoper0a6b37af0871\PHPStan\Type\Type;
}
