<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeCorrector;

use _PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\ClassExistenceStaticHelper;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Reflection\ClassReflectionTypesResolver;
final class ParentClassLikeTypeCorrector
{
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @var ClassReflectionTypesResolver
     */
    private $classReflectionTypesResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Reflection\ClassReflectionTypesResolver $classReflectionTypesResolver, \_PhpScoper0a2ac50786fa\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->typeFactory = $typeFactory;
        $this->reflectionProvider = $reflectionProvider;
        $this->classReflectionTypesResolver = $classReflectionTypesResolver;
    }
    public function correct(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($type instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            if (!\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($type->getClassName())) {
                return $type;
            }
            $allTypes = $this->getClassLikeTypesByClassName($type->getClassName());
            return $this->typeFactory->createObjectTypeOrUnionType($allTypes);
        }
        $classNames = \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeUtils::getDirectClassNames($type);
        $allTypes = [];
        foreach ($classNames as $className) {
            if (!\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\ClassExistenceStaticHelper::doesClassLikeExist($className)) {
                continue;
            }
            $allTypes = \array_merge($allTypes, $this->getClassLikeTypesByClassName($className));
        }
        return $this->typeFactory->createObjectTypeOrUnionType($allTypes);
    }
    /**
     * @return string[]
     */
    private function getClassLikeTypesByClassName(string $className) : array
    {
        $classReflection = $this->reflectionProvider->getClass($className);
        $classLikeTypes = $this->classReflectionTypesResolver->resolve($classReflection);
        return \array_unique($classLikeTypes);
    }
}
