<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver;

use Iterator;
use PhpParser\Node\Expr\Variable;
use PHPStan\Type\ObjectType;
use PHPStan\Type\ThisType;
use PHPStan\Type\TypeWithClassName;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Fixture\ThisClass;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType;
use ReflectionClass;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\VariableTypeResolver
 */
final class VariableTypeResolverTest extends \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \PHPStan\Type\TypeWithClassName $expectedTypeWithClassName) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \PhpParser\Node\Expr\Variable::class);
        $resolvedType = $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]);
        $this->assertInstanceOf(\PHPStan\Type\TypeWithClassName::class, $resolvedType);
        /** @var TypeWithClassName $resolvedType */
        $this->assertEquals($expectedTypeWithClassName->getClassName(), $resolvedType->getClassName());
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Fixture/this_class.php.inc', 0, new \PHPStan\Type\ThisType(new \ReflectionClass(\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Fixture\ThisClass::class))]);
        $anotherTypeObjectType = new \PHPStan\Type\ObjectType(\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType::class);
        (yield [__DIR__ . '/Fixture/new_class.php.inc', 1, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Fixture/new_class.php.inc', 3, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Fixture/assignment_class.php.inc', 2, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Fixture/argument_typehint.php.inc', 1, $anotherTypeObjectType]);
    }
}
