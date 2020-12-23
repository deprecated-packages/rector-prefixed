<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Type;

interface SubtractableType extends \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
{
    public function subtract(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function getTypeWithoutSubtractedType() : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function changeSubtractedType(?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $subtractedType) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
    public function getSubtractedType() : ?\_PhpScoper0a2ac50786fa\PHPStan\Type\Type;
}
