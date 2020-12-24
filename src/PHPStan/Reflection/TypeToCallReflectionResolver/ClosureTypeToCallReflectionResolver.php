<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\Native\NativeFunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\TrinaryLogic;
use _PhpScoper0a6b37af0871\PHPStan\Type\ClosureType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface;
final class ClosureTypeToCallReflectionResolver implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface
{
    public function supports(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ClosureType;
    }
    /**
     * @param ClosureType $type
     */
    public function resolve(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer) : \_PhpScoper0a6b37af0871\PHPStan\Reflection\Native\NativeFunctionReflection
    {
        return new \_PhpScoper0a6b37af0871\PHPStan\Reflection\Native\NativeFunctionReflection('{closure}', $type->getCallableParametersAcceptors($classMemberAccessAnswerer), null, \_PhpScoper0a6b37af0871\PHPStan\TrinaryLogic::createMaybe());
    }
}
