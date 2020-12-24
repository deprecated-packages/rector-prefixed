<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\AnotherTrait;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithParentClass;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithParentInterface;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithParentTrait;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithTrait;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ParentClass;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterface;
use _PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\ClassAndInterfaceTypeResolver
 */
final class ClassTypeResolverTest extends \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider dataProvider()
     */
    public function test(string $file, int $nodePosition, \_PhpScopere8e811afab72\PHPStan\Type\Type $expectedType) : void
    {
        $variableNodes = $this->getNodesForFileOfType($file, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class);
        $this->assertEquals($expectedType, $this->nodeTypeResolver->resolve($variableNodes[$nodePosition]));
    }
    public function dataProvider() : \Iterator
    {
        (yield [__DIR__ . '/Source/ClassWithParentInterface.php', 0, \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithParentInterface::class, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterface::class])]);
        (yield [__DIR__ . '/Source/ClassWithParentClass.php', 0, \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithParentClass::class, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ParentClass::class])]);
        (yield [__DIR__ . '/Source/ClassWithTrait.php', 0, \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithTrait::class, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\AnotherTrait::class])]);
        (yield [__DIR__ . '/Source/ClassWithParentTrait.php', 0, \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithParentTrait::class, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ClassWithTrait::class, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\AnotherTrait::class])]);
        (yield [__DIR__ . '/Source/AnonymousClass.php', 0, \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType(['AnonymousClassdefa360846b84894d4be1b25c2ce6da9', \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\ParentClass::class, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\SomeInterface::class, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\ClassAndInterfaceTypeResolver\Source\AnotherTrait::class])]);
    }
}
