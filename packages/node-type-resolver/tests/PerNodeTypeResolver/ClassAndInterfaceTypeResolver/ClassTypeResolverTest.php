<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver;

use Iterator;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\AnotherTrait;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithParentClass;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithParentInterface;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithParentTrait;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithTrait;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ParentClass;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterface;
use _PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\ClassAndInterfaceTypeResolver
 */
final class ClassTypeResolverTest extends \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider dataProvider()
     */
    public function test(string $file, int $nodePosition, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $expectedType) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_::class);
        $this->assertEquals($expectedType, $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]));
    }
    public function dataProvider() : \Iterator
    {
        (yield [__DIR__ . '/Source/ClassWithParentInterface.php', 0, \_PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithParentInterface::class, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterface::class])]);
        (yield [__DIR__ . '/Source/ClassWithParentClass.php', 0, \_PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithParentClass::class, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ParentClass::class])]);
        (yield [__DIR__ . '/Source/ClassWithTrait.php', 0, \_PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithTrait::class, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\AnotherTrait::class])]);
        (yield [__DIR__ . '/Source/ClassWithParentTrait.php', 0, \_PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithParentTrait::class, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithTrait::class, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\AnotherTrait::class])]);
        (yield [__DIR__ . '/Source/AnonymousClass.php', 0, \_PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType(['AnonymousClassdefa360846b84894d4be1b25c2ce6da9', \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ParentClass::class, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterface::class, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\AnotherTrait::class])]);
    }
}
