<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Trait_;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use ReflectionClass;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\TraitTypeResolverTest
 */
final class TraitTypeResolver implements \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Trait_::class];
    }
    /**
     * @param Trait_ $traitNode
     */
    public function resolve(\_PhpScoper0a2ac50786fa\PhpParser\Node $traitNode) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        $reflectionClass = new \ReflectionClass((string) $traitNode->namespacedName);
        $types = [];
        $types[] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($reflectionClass->getName());
        foreach ($reflectionClass->getTraits() as $usedTraitReflection) {
            $types[] = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($usedTraitReflection->getName());
        }
        if (\count($types) === 1) {
            return $types[0];
        }
        if (\count($types) > 1) {
            return new \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType($types);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
}
