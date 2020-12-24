<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use ReflectionClass;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\TraitTypeResolverTest
 */
final class TraitTypeResolver implements \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_::class];
    }
    /**
     * @param Trait_ $traitNode
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $traitNode) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $reflectionClass = new \ReflectionClass((string) $traitNode->namespacedName);
        $types = [];
        $types[] = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($reflectionClass->getName());
        foreach ($reflectionClass->getTraits() as $usedTraitReflection) {
            $types[] = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($usedTraitReflection->getName());
        }
        if (\count($types) === 1) {
            return $types[0];
        }
        if (\count($types) > 1) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\UnionType($types);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
}
