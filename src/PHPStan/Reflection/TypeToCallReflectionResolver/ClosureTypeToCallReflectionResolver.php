<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeFunctionReflection;
use _PhpScopere8e811afab72\PHPStan\TrinaryLogic;
use _PhpScopere8e811afab72\PHPStan\Type\ClosureType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface;
final class ClosureTypeToCallReflectionResolver implements \_PhpScopere8e811afab72\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface
{
    public function supports(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof \_PhpScopere8e811afab72\PHPStan\Type\ClosureType;
    }
    /**
     * @param ClosureType $type
     */
    public function resolve(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer) : \_PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeFunctionReflection
    {
        return new \_PhpScopere8e811afab72\PHPStan\Reflection\Native\NativeFunctionReflection('{closure}', $type->getCallableParametersAcceptors($classMemberAccessAnswerer), null, \_PhpScopere8e811afab72\PHPStan\TrinaryLogic::createMaybe());
    }
}
