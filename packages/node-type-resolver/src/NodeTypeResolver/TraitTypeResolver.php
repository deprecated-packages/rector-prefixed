<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Trait_;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface;
use ReflectionClass;
/**
 * @see \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\TraitTypeResolverTest
 */
final class TraitTypeResolver implements \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Contract\NodeTypeResolverInterface
{
    /**
     * @return string[]
     */
    public function getNodeClasses() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Trait_::class];
    }
    /**
     * @param Trait_ $traitNode
     */
    public function resolve(\_PhpScoperb75b35f52b74\PhpParser\Node $traitNode) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $reflectionClass = new \ReflectionClass((string) $traitNode->namespacedName);
        $types = [];
        $types[] = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($reflectionClass->getName());
        foreach ($reflectionClass->getTraits() as $usedTraitReflection) {
            $types[] = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($usedTraitReflection->getName());
        }
        if (\count($types) === 1) {
            return $types[0];
        }
        if (\count($types) > 1) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType($types);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
}
