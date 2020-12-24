<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\FunctionReflection;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\MethodReflection;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface;
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
    public function resolve(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer)
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
