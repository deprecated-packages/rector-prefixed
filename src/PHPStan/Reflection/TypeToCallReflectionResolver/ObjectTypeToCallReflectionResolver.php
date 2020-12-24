<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Core\PHPStan\Reflection\TypeToCallReflectionResolver;

use _PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection;
use _PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface;
/**
 * @see https://github.com/phpstan/phpstan-src/blob/b1fd47bda2a7a7d25091197b125c0adf82af6757/src/Type/ObjectType.php#L705
 */
final class ObjectTypeToCallReflectionResolver implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\PHPStan\Reflection\TypeToCallReflectionResolver\TypeToCallReflectionResolverInterface
{
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\Reflection\ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }
    public function supports(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type) : bool
    {
        return $type instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
    }
    /**
     * @param ObjectType $type
     */
    public function resolve(\_PhpScoper0a6b37af0871\PHPStan\Type\Type $type, \_PhpScoper0a6b37af0871\PHPStan\Reflection\ClassMemberAccessAnswerer $classMemberAccessAnswerer) : ?\_PhpScoper0a6b37af0871\PHPStan\Reflection\MethodReflection
    {
        $className = $type->getClassName();
        if (!$this->reflectionProvider->hasClass($className)) {
            return null;
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        if (!$classReflection->hasNativeMethod('__invoke')) {
            return null;
        }
        return $classReflection->getNativeMethod('__invoke');
    }
}
