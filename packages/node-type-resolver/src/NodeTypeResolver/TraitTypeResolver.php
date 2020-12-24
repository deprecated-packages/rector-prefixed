<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Trait_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use ReflectionClass;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\TraitTypeResolverTest
 */
final class TraitTypeResolver implements \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Trait_::class];
    }
    /**
     * @param Trait_ $traitNode
     */
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $traitNode) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        $reflectionClass = new \ReflectionClass((string) $traitNode->namespacedName);
        $types = [];
        $types[] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($reflectionClass->getName());
        foreach ($reflectionClass->getTraits() as $usedTraitReflection) {
            $types[] = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($usedTraitReflection->getName());
        }
        if (\count($types) === 1) {
            return $types[0];
        }
        if (\count($types) > 1) {
            return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType($types);
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
    }
}
