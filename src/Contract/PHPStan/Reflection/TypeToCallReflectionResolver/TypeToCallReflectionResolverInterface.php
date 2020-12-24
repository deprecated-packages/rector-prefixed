<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
interface TypeToCallReflectionResolverInterface
{
    public function supports(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : bool;
    /**
     * @return FunctionReflection|MethodReflection|null
     */
    public function resolve(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer);
}
