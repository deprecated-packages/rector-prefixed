<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver;

use Iterator;
use PhpParser\Node\Expr\Variable;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\ThisClass;
use Rector\NodeTypeResolver\Tests\Source\AnotherClass;
use Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\VariableTypeResolver
 */
final class VariableTypeResolverTest extends \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \PHPStan\Type\Type $expectedType) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \PhpParser\Node\Expr\Variable::class);
        $resolvedType = $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]);
        $this->assertEquals($expectedType, $resolvedType);
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/ThisClass.php', 0, \Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper::createUnionObjectType([\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\ThisClass::class, \Rector\NodeTypeResolver\Tests\Source\AnotherClass::class])]);
        $anotherTypeObjectType = new \PHPStan\Type\ObjectType(\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType::class);
        (yield [__DIR__ . '/Source/NewClass.php', 1, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Source/NewClass.php', 3, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Source/AssignmentClass.php', 2, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Source/ArgumentTypehint.php', 1, $anotherTypeObjectType]);
    }
}
