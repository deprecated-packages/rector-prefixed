<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Native\NativeFunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClosureType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface;
final class ClosureTypeToCallReflectionResolver implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface
{
    public function supports(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClosureType;
    }
    /**
     * @param ClosureType $type
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Native\NativeFunctionReflection
    {
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Native\NativeFunctionReflection('{closure}', $type->getCallableParametersAcceptors($classMemberAccessAnswerer), null, \_PhpScoper2a4e7ab1ecbc\PHPStan\TrinaryLogic::createMaybe());
    }
}
