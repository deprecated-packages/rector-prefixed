<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\OverrideGuard;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\NodeVisitor;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType;
final class ClassMethodReturnTypeOverrideGuard
{
    /**
     * @var array<string, array<string>>
     */
    private const CHAOTIC_CLASS_METHOD_NAMES = [\_PhpScoperb75b35f52b74\PhpParser\NodeVisitor::class => ['enterNode', 'leaveNode', 'beforeTraverse', 'afterTraverse']];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function shouldSkipClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // 1. skip magic methods
        if ($this->nodeNameResolver->isName($classMethod->name, '__*')) {
            return \true;
        }
        // 2. skip chaotic contract class methods
        return $this->shouldSkipChaoticClassMethods($classMethod);
    }
    public function shouldSkipClassMethodOldTypeWithNewType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $oldType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $newType) : bool
    {
        if ($oldType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return \false;
        }
        if ($oldType->isSuperTypeOf($newType)->yes()) {
            return \true;
        }
        return $this->isArrayMutualType($newType, $oldType);
    }
    private function shouldSkipChaoticClassMethods(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        /** @var string|null $className */
        $className = $classMethod->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
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
    private function isArrayMutualType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $newType, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $oldType) : bool
    {
        if (!$newType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            return \false;
        }
        if (!$oldType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType) {
            return \false;
        }
        $oldTypeWithClassName = $oldType->getItemType();
        if (!$oldTypeWithClassName instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        $arrayItemType = $newType->getItemType();
        if (!$arrayItemType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return \false;
        }
        $isMatchingClassTypes = \false;
        foreach ($arrayItemType->getTypes() as $newUnionedType) {
            if (!$newUnionedType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
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
    private function resolveClass(\_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName $typeWithClassName) : string
    {
        if ($typeWithClassName instanceof \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\ShortenedObjectType) {
            return $typeWithClassName->getFullyQualifiedName();
        }
        return $typeWithClassName->getClassName();
    }
}
