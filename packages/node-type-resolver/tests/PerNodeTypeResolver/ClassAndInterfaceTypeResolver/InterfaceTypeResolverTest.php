<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver;

use Iterator;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterfaceWithParentInterface;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeParentInterface;
use _PhpScoper0a6b37af0871\Rector\PHPStan\TypeFactoryStaticHelper;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\ClassAndInterfaceTypeResolver
 */
final class InterfaceTypeResolverTest extends \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider dataProvider()
     */
    public function test(string $file, int $nodePosition, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $expectedType) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Interface_::class);
        $this->assertEquals($expectedType, $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]));
    }
    public function dataProvider() : \Iterator
    {
        $unionType = \_PhpScoper0a6b37af0871\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterfaceWithParentInterface::class, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeParentInterface::class]);
        (yield [__DIR__ . '/Source/SomeInterfaceWithParentInterface.php', 0, $unionType]);
    }
}
