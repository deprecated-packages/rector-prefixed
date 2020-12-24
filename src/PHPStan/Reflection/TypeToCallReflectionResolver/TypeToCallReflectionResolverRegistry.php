<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\FunctionReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface;
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
    public function resolve(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer)
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
