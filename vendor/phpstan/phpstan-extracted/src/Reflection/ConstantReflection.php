<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Reflection;

interface ConstantReflection extends \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberReflection, \_PhpScoper0a6b37af0871\PHPStan\Reflection\GlobalConstantReflection
{
    /**
     * @return mixed
     */
    public function getValue();
}
