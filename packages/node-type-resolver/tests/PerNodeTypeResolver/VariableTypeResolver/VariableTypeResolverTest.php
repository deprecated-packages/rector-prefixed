<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\ThisClass;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\VariableTypeResolver
 */
final class VariableTypeResolverTest extends \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $expectedType) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable::class);
        $this->assertEquals($expectedType, $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]));
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/ThisClass.php', 0, \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\ThisClass::class, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\Source\AnotherClass::class])]);
        $anotherTypeObjectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType::class);
        (yield [__DIR__ . '/Source/NewClass.php', 1, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Source/NewClass.php', 3, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Source/AssignmentClass.php', 2, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Source/ArgumentTypehint.php', 1, $anotherTypeObjectType]);
    }
}
