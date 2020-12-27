<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection;

interface ConstantReflection extends \RectorPrefix20201227\PHPStan\Reflection\ClassMemberReflection, \RectorPrefix20201227\PHPStan\Reflection\GlobalConstantReflection
{
    /**
     * @return mixed
     */
    public function getValue();
}
