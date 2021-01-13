<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver;

use Iterator;
use PhpParser\Node\Name;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use Rector\NodeTypeResolver\Tests\Source\AnotherClass;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\NameTypeResolver
 */
final class NameTypeResolverTest extends \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \PHPStan\Type\Type $expectedType) : void
    {
        $nameNodes = $this->getNodesForFileOfType($file, \PhpParser\Node\Name::class);
        $resolvedType = $this->nodeTypeResolver->resolve($nameNodes[$nodePosition]);
        $this->assertEquals($expectedType, $resolvedType);
    }
    public function provideData() : \Iterator
    {
        $expectedObjectType = new \PHPStan\Type\ObjectType(\Rector\NodeTypeResolver\Tests\Source\AnotherClass::class);
        # test new
        (yield [__DIR__ . '/Source/ParentCall.php', 2, $expectedObjectType]);
    }
}
