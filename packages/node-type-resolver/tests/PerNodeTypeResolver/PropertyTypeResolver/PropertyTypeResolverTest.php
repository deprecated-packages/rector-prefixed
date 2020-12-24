<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\PHPStan\Type\NullType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\ClassThatExtendsHtml;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\Html;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\SomeChild;
use _PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\PropertyTypeResolver
 */
final class PropertyTypeResolverTest extends \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \_PhpScopere8e811afab72\PHPStan\Type\Type $expectedType) : void
    {
        $propertyNodes = $this->getNodesForFileOfType($file, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class);
        $resolvedType = $this->nodeTypeResolver->resolve($propertyNodes[$nodePosition]);
        // type is as expected
        $expectedTypeClass = \get_class($expectedType);
        $this->assertInstanceOf($expectedTypeClass, $resolvedType);
        $expectedTypeAsString = $this->getStringFromType($expectedType);
        $resolvedTypeAsString = $this->getStringFromType($resolvedType);
        $this->assertEquals($expectedTypeAsString, $resolvedTypeAsString);
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/MethodParamDocBlock.php', 0, new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\Html::class)]);
        (yield [__DIR__ . '/Source/MethodParamDocBlock.php', 1, \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\ClassThatExtendsHtml::class, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\Html::class])]);
        // mimics failing test from DomainDrivenDesign set
        $unionType = \_PhpScopere8e811afab72\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\SomeChild::class, new \_PhpScopere8e811afab72\PHPStan\Type\NullType()]);
        (yield [__DIR__ . '/Source/ActionClass.php', 0, $unionType]);
    }
    private function getStringFromType(\_PhpScopere8e811afab72\PHPStan\Type\Type $type) : string
    {
        return $type->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::precise());
    }
}
