<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterfaceWithParentInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeParentInterface;
use _PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\ClassAndInterfaceTypeResolver
 */
final class InterfaceTypeResolverTest extends \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider dataProvider()
     */
    public function test(string $file, int $nodePosition, \_PhpScopere8e811afab72\PHPStan\Type\Type $expectedType) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_::class);
        $this->assertEquals($expectedType, $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]));
    }
    public function dataProvider() : \Iterator
    {
        $unionType = \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterfaceWithParentInterface::class, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeParentInterface::class]);
        (yield [__DIR__ . '/Source/SomeInterfaceWithParentInterface.php', 0, $unionType]);
    }
}
