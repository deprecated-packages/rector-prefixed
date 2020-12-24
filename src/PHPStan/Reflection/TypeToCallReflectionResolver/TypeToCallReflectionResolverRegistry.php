<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodReflection;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface;
final class TypeToCallReflectionResolverRegistry
{
    /**
     * @var TypeToCallReflectionResolverInterface[]
     */
    private $resolvers = [];
    /**
     * @param TypeToCallReflectionResolverInterface[] $resolvers
     */
    public function __construct(array $resolvers)
    {
        $this->resolvers = $resolvers;
    }
    /**
     * @return FunctionReflection|MethodReflection|null
     */
    public function resolve(\_PhpScopere8e811afab72\PHPStan\Type\Type $type, \_PhpScopere8e811afab72\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer)
    {
        foreach ($this->resolvers as $resolver) {
            if (!$resolver->supports($type)) {
                continue;
            }
            return $resolver->resolve($type, $classMemberAccessAnswerer);
        }
        return null;
    }
}
