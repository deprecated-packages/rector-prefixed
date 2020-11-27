<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\NodeTypeResolver;

use PhpParser\Node;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use ReflectionClass;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\TraitTypeResolverTest
 */
final class TraitTypeResolver implements \Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\PhpParser\Node\Stmt\Trait_::class];
    }
    /**
     * @param Trait_ $traitNode
     */
    public function resolve(\PhpParser\Node $traitNode) : \PHPStan\Type\Type
    {
        $reflectionClass = new \ReflectionClass((string) $traitNode->namespacedName);
        $types = [];
        $types[] = new \PHPStan\Type\ObjectType($reflectionClass->getName());
        foreach ($reflectionClass->getTraits() as $usedTraitReflection) {
            $types[] = new \PHPStan\Type\ObjectType($usedTraitReflection->getName());
        }
        if (\count($types) === 1) {
            return $types[0];
        }
        if (\count($types) > 1) {
            return new \PHPStan\Type\UnionType($types);
        }
        return new \PHPStan\Type\MixedType();
    }
}
