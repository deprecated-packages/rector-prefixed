<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ParamTypeResolver;

use Iterator;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ParamTypeResolver\Source\Html;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\ParamTypeResolver
 */
final class ParamTypeResolverTest extends \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $expectedType) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \_PhpScoper0a6b37af0871\PhpParser\Node\Param::class);
        $resolvedType = $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]);
        $this->assertEquals($expectedType, $resolvedType);
    }
    public function provideData() : \Iterator
    {
        $objectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ParamTypeResolver\Source\Html::class);
        (yield [__DIR__ . '/Source/MethodParamTypeHint.php', 0, $objectType]);
        (yield [__DIR__ . '/Source/MethodParamDocBlock.php', 0, $objectType]);
    }
}
