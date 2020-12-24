<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
interface TypeToCallReflectionResolverInterface
{
    public function supports(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool;
    /**
     * @return FunctionReflection|MethodReflection|null
     */
    public function resolve(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer);
}
