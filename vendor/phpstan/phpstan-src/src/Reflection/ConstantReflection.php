<?php

declare (strict_types=1);
namespace PHPStan\Reflection;

interface ConstantReflection extends \PHPStan\Reflection\ClassMemberReflection, \PHPStan\Reflection\GlobalConstantReflection
{
    /**
     * @return mixed
     */
    public function getValue();
}
