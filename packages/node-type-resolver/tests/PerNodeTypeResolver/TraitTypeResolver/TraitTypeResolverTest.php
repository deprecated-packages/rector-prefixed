<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\Source\AnotherTrait;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\Source\TraitWithTrait;
use _PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\TraitTypeResolver
 */
final class TraitTypeResolverTest extends \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \_PhpScopere8e811afab72\PHPStan\Type\Type $expectedType) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_::class);
        $this->assertEquals($expectedType, $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]));
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/TraitWithTrait.php', 0, \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\Source\AnotherTrait::class, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\TraitTypeResolver\Source\TraitWithTrait::class])]);
    }
}
