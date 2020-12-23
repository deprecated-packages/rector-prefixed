<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
interface TypeToCallReflectionResolverInterface
{
    public function supports(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool;
    /**
     * @return FunctionReflection|MethodReflection|null
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer);
}
