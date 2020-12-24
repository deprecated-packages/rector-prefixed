<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
interface ParameterReflection
{
    public function getName() : string;
    public function isOptional() : bool;
    public function getType() : \_PhpScoperb75b35f52b74\PHPStan\Type\Type;
    public function passedByReference() : \_PhpScoperb75b35f52b74\PHPStan\Reflection\PassedByReference;
    public function isVariadic() : bool;
    public function getDefaultValue() : ?\_PhpScoperb75b35f52b74\PHPStan\Type\Type;
}
