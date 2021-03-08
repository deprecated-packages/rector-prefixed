<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver;

use Iterator;
use PhpParser\Node\Stmt\Interface_;
use PHPStan\Type\ObjectType;
use PHPStan\Type\TypeWithClassName;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterfaceWithParentInterface;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\ClassAndInterfaceTypeResolver
 */
final class InterfaceTypeResolverTest extends \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider dataProvider()
     */
    public function test(string $file, int $nodePosition, \PHPStan\Type\TypeWithClassName $expectedTypeWithClassName) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \PhpParser\Node\Stmt\Interface_::class);
        $resolvedType = $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]);
        $this->assertInstanceOf(\PHPStan\Type\TypeWithClassName::class, $resolvedType);
        /** @var TypeWithClassName $resolvedType */
        $this->assertEquals($expectedTypeWithClassName->getClassName(), $resolvedType->getClassName());
    }
    /**
     * @return Iterator<int[]|string[]|ObjectType[]>
     */
    public function dataProvider() : \Iterator
    {
        (yield [__DIR__ . '/Source/SomeInterfaceWithParentInterface.php', 0, new \PHPStan\Type\ObjectType(\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterfaceWithParentInterface::class)]);
    }
}
