<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection;

interface ConstantReflection extends \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberReflection, \_PhpScoperb75b35f52b74\PHPStan\Reflection\GlobalConstantReflection
{
    /**
     * @return mixed
     */
    public function getValue();
}
