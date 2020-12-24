<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

interface SubtractableType extends \_PhpScoperb75b35f52b74\PHPStan\Type\Type
{
    public function subtract(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function getTypeWithoutSubtractedType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function changeSubtractedType(?\_PhpScoperb75b35f52b74\PHPStan\Type\Type $subtractedType) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function getSubtractedType() : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type;
}
