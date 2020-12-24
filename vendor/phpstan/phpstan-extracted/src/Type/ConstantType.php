<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

interface ConstantType extends \_PhpScoperb75b35f52b74\PHPStan\Type\Type
{
    public function generalize() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
}
