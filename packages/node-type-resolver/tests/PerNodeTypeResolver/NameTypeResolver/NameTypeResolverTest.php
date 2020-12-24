<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\NameTypeResolver;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\NameTypeResolver
 */
final class NameTypeResolverTest extends \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \_PhpScopere8e811afab72\PHPStan\Type\Type $expectedType) : void
    {
        $nameNodes = $this->getNodesForFileOfType($file, \_PhpScopere8e811afab72\PhpParser\Node\Name::class);
        $this->assertEquals($expectedType, $this->nodeTypeResolver->resolve($nameNodes[$nodePosition]));
    }
    public function provideData() : \Iterator
    {
        $expectedObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\Source\AnotherClass::class);
        # test new
        (yield [__DIR__ . '/Source/ParentCall.php', 2, $expectedObjectType]);
    }
}
