<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\ThisClass;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
use _PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\VariableTypeResolver
 */
final class VariableTypeResolverTest extends \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \_PhpScopere8e811afab72\PHPStan\Type\Type $expectedType) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable::class);
        $this->assertEquals($expectedType, $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]));
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/ThisClass.php', 0, \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\ThisClass::class, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\Source\AnotherClass::class])]);
        $anotherTypeObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType::class);
        (yield [__DIR__ . '/Source/NewClass.php', 1, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Source/NewClass.php', 3, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Source/AssignmentClass.php', 2, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Source/ArgumentTypehint.php', 1, $anotherTypeObjectType]);
    }
}
