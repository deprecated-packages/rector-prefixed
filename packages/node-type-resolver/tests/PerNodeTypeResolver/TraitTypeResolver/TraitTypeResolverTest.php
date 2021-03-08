<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver;

use Iterator;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\Source\AnotherTrait;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\Source\TraitWithTrait;
use Rector\StaticTypeMapper\TypeFactory\UnionTypeFactory;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\TraitTypeResolver
 */
final class TraitTypeResolverTest extends \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \PHPStan\Type\Type $expectedType) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \PhpParser\Node\Stmt\Trait_::class);
        $resolvedType = $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]);
        $this->assertEquals($expectedType, $resolvedType);
    }
    /**
     * @return Iterator<int[]|string[]|UnionType[]>
     */
    public function provideData() : \Iterator
    {
        $unionTypeFactory = new \Rector\StaticTypeMapper\TypeFactory\UnionTypeFactory();
        (yield [__DIR__ . '/Source/TraitWithTrait.php', 0, $unionTypeFactory->createUnionObjectType([\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\Source\AnotherTrait::class, \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\Source\TraitWithTrait::class])]);
    }
}
