<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Type;

interface SubtractableType extends \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
{
    public function subtract(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function getTypeWithoutSubtractedType() : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function changeSubtractedType(?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $subtractedType) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
    public function getSubtractedType() : ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
}
