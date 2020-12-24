<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Type;

interface TypeWithClassName extends \_PhpScoperb75b35f52b74\PHPStan\Type\Type
{
    public function getClassName() : string;
    public function getAncestorWithClassName(string $className) : ?\_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
}
