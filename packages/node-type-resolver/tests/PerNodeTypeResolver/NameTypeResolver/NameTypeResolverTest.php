<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver;

use Iterator;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\NameTypeResolver
 */
final class NameTypeResolverTest extends \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $expectedType) : void
    {
        $nameNodes = $this->getNodesForFileOfType($file, \_PhpScoper0a6b37af0871\PhpParser\Node\Name::class);
        $this->assertEquals($expectedType, $this->nodeTypeResolver->resolve($nameNodes[$nodePosition]));
    }
    public function provideData() : \Iterator
    {
        $expectedObjectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\Source\AnotherClass::class);
        # test new
        (yield [__DIR__ . '/Source/ParentCall.php', 2, $expectedObjectType]);
    }
}
