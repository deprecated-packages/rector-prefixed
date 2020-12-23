<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\OverrideGuard;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitor;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\PHPStan\Type\ShortenedObjectType;
final class ClassMethodReturnTypeOverrideGuard
{
    /**
     * @var array<string, array<string>>
     */
    private const CHAOTIC_CLASS_METHOD_NAMES = [\_PhpScoper0a2ac50786fa\PhpParser\NodeVisitor::class => ['enterNode', 'leaveNode', 'beforeTraverse', 'afterTraverse']];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function shouldSkipClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // 1. skip magic methods
        if ($this->nodeNameResolver->isName($classMethod->name, '__*')) {
            return \true;
        }
        // 2. skip chaotic contract class methods
        return $this->shouldSkipChaoticClassMethods($classMethod);
    }
    public function shouldSkipClassMethodOldTypeWithNewType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $oldType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $newType) : bool
    {
        if ($oldType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType) {
            return \false;
        }
        if ($oldType->isSuperTypeOf($newType)->yes()) {
            return \true;
        }
        return $this->isArrayMutualType($newType, $oldType);
    }
    private function shouldSkipChaoticClassMethods(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var string|null $className */
        $className = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \false;
        }
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($classMethod);
        foreach (self::CHAOTIC_CLASS_METHOD_NAMES as $chaoticClass => $chaoticMethodNames) {
            if (!\is_a($className, $chaoticClass, \true)) {
                continue;
            }
            return \in_array($methodName, $chaoticMethodNames, \true);
        }
        return \false;
    }
    private function isArrayMutualType(\_PhpScoper0a2ac50786fa\PHPStan\Type\Type $newType, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $oldType) : bool
    {
        if (!$newType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$oldType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType) {
            return \false;
        }
        $oldTypeWithClassName = $oldType->getItemType();
        if (!$oldTypeWithClassName instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        $arrayItemType = $newType->getItemType();
        if (!$arrayItemType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType) {
            return \false;
        }
        $isMatchingClassTypes = \false;
        foreach ($arrayItemType->getTypes() as $newUnionedType) {
            if (!$newUnionedType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName) {
                return \false;
            }
            $oldClass = $this->resolveClass($oldTypeWithClassName);
            $newClass = $this->resolveClass($newUnionedType);
            if (\is_a($oldClass, $newClass, \true) || \is_a($newClass, $oldClass, \true)) {
                $isMatchingClassTypes = \true;
            } else {
                return \false;
            }
        }
        return $isMatchingClassTypes;
    }
    private function resolveClass(\_PhpScoper0a2ac50786fa\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \_PhpScoper0a2ac50786fa\Rector\PHPStan\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        return $typeWithClassName->getClassName();
    }
}
