<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface ParameterReflectionWithPhpDocs extends \_PhpScoperb75b35f52b74\PHPStan\Reflection\ParameterReflection
{
    public function getPhpDocType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function getNativeType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
}
