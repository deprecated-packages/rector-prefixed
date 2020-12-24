<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver;

use Iterator;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\ThisClass;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\Source\AnotherClass;
use _PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\VariableTypeResolver
 */
final class VariableTypeResolverTest extends \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $expectedType) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable::class);
        $this->assertEquals($expectedType, $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]));
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/ThisClass.php', 0, \_PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\ThisClass::class, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\Source\AnotherClass::class])]);
        $anotherTypeObjectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\VariableTypeResolver\Source\AnotherType::class);
        (yield [__DIR__ . '/Source/NewClass.php', 1, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Source/NewClass.php', 3, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Source/AssignmentClass.php', 2, $anotherTypeObjectType]);
        (yield [__DIR__ . '/Source/ArgumentTypehint.php', 1, $anotherTypeObjectType]);
    }
}
