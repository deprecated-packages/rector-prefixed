<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a2ac50786fa\PHPStan\Reflection\Native\NativeFunctionReflection;
use _PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ClosureType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface;
final class ClosureTypeToCallReflectionResolver implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface
{
    public function supports(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ClosureType;
    }
    /**
     * @param ClosureType $type
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer) : \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Native\NativeFunctionReflection
    {
        return new \_PhpScoper0a2ac50786fa\PHPStan\Reflection\Native\NativeFunctionReflection('{closure}', $type->getCallableParametersAcceptors($classMemberAccessAnswerer), null, \_PhpScoper0a2ac50786fa\PHPStan\TrinaryLogic::createMaybe());
    }
}
