<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ParamTypeResolver;

use Iterator;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ParamTypeResolver\Source\Html;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\ParamTypeResolver
 */
final class ParamTypeResolverTest extends \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $expectedType) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \_PhpScoperb75b35f52b74\PhpParser\Node\Param::class);
        $resolvedType = $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]);
        $this->assertEquals($expectedType, $resolvedType);
    }
    public function provideData() : \Iterator
    {
        $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ParamTypeResolver\Source\Html::class);
        (yield [__DIR__ . '/Source/MethodParamTypeHint.php', 0, $objectType]);
        (yield [__DIR__ . '/Source/MethodParamDocBlock.php', 0, $objectType]);
    }
}
