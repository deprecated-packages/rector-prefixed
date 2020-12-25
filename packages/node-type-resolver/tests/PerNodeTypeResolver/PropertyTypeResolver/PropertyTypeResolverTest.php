<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver;

use Iterator;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\VerbosityLevel;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\ClassThatExtendsHtml;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\Html;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\SomeChild;
use Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\PropertyTypeResolver
 */
final class PropertyTypeResolverTest extends \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \PHPStan\Type\Type $expectedType) : void
    {
        $propertyNodes = $this->getNodesForFileOfType($file, \PhpParser\Node\Stmt\Property::class);
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
        (yield [__DIR__ . '/Source/MethodParamDocBlock.php', 0, new \PHPStan\Type\ObjectType(\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\Html::class)]);
        (yield [__DIR__ . '/Source/MethodParamDocBlock.php', 1, \Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper::createUnionObjectType([\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\ClassThatExtendsHtml::class, \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\Html::class])]);
        // mimics failing test from DomainDrivenDesign set
        $unionType = \Rector\StaticTypeMapper\TypeFactory\TypeFactoryStaticHelper::createUnionObjectType([\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\SomeChild::class, new \PHPStan\Type\NullType()]);
        (yield [__DIR__ . '/Source/ActionClass.php', 0, $unionType]);
    }
    private function getStringFromType(\PHPStan\Type\Type $type) : string
    {
        return $type->describe(\PHPStan\Type\VerbosityLevel::precise());
    }
}
