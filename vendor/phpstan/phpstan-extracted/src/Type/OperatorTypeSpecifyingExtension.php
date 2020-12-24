<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

interface OperatorTypeSpecifyingExtension
{
    public function isOperatorSupported(string $operatorSigil, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $leftSide, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $rightSide) : bool;
    public function specifyType(string $operatorSigil, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $leftSide, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $rightSide) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
}
