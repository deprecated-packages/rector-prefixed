<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver;

use Iterator;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\NameTypeResolver
 */
final class NameTypeResolverTest extends \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $expectedType) : void
    {
        $nameNodes = $this->getNodesForFileOfType($file, \_PhpScoperb75b35f52b74\PhpParser\Node\Name::class);
        $this->assertEquals($expectedType, $this->nodeTypeResolver->resolve($nameNodes[$nodePosition]));
    }
    public function provideData() : \Iterator
    {
        $expectedObjectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\Source\AnotherClass::class);
        # test new
        (yield [__DIR__ . '/Source/ParentCall.php', 2, $expectedObjectType]);
    }
}
