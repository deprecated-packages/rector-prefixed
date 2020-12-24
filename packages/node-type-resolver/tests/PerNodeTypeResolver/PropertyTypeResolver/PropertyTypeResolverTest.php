<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver;

use Iterator;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\ClassThatExtendsHtml;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\Html;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\SomeChild;
use _PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\PropertyTypeResolver
 */
final class PropertyTypeResolverTest extends \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\AbstractNodeTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $expectedType) : void
    {
        $propertyNodes = $this->getNodesForFileOfType($file, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property::class);
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
        (yield [__DIR__ . '/Source/MethodParamDocBlock.php', 0, new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\Html::class)]);
        (yield [__DIR__ . '/Source/MethodParamDocBlock.php', 1, \_PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\ClassThatExtendsHtml::class, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\Html::class])]);
        // mimics failing test from DomainDrivenDesign set
        $unionType = \_PhpScoperb75b35f52b74\Rector\PHPStan\TypeFactoryStaticHelper::createUnionObjectType([\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyTypeResolver\Source\SomeChild::class, new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType()]);
        (yield [__DIR__ . '/Source/ActionClass.php', 0, $unionType]);
    }
    private function getStringFromType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : string
    {
        return $type->describe(\_PhpScoperb75b35f52b74\PHPStan\Type\VerbosityLevel::precise());
    }
}
