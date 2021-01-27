<?php

declare (strict_types=1);
namespace Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver;

use Iterator;
use PhpParser\Node\Expr\PropertyFetch;
use PHPStan\Type\ArrayType;
use PHPStan\Type\ErrorType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\UnionType;
use Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\Source\Abc;
/**
 * @see \Rector\NodeTypeResolver\NodeTypeResolver\PropertyFetchTypeResolver
 */
final class PropertyFetchTypeResolverTest extends \Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\AbstractPropertyFetchTypeResolverTest
{
    /**
     * @dataProvider provideData()
     */
    public function test(string $file, int $nodePosition, \PHPStan\Type\Type $expectedType) : void
    {
        $propertyFetchNodes = $this->getNodesForFileOfType($file, \PhpParser\Node\Expr\PropertyFetch::class);
        $resolvedType = $this->nodeTypeResolver->resolve($propertyFetchNodes[$nodePosition]);
        $expectedTypeClass = \get_class($expectedType);
        $this->assertInstanceOf($expectedTypeClass, $resolvedType);
        $expectedTypeAsString = $this->getStringFromType($expectedType);
        $resolvedTypeAsString = $this->getStringFromType($resolvedType);
        $this->assertEquals($expectedTypeAsString, $resolvedTypeAsString);
    }
    public function provideData() : \Iterator
    {
        foreach ([__DIR__ . '/Source/phpDocPropertyFetchOnTypedVar.php', __DIR__ . '/Source/phpDocPropertyFetchOnVarInScope.php'] as $file) {
            (yield [$file, 0, new \PHPStan\Type\StringType()]);
            (yield [$file, 1, new \PHPStan\Type\IntegerType()]);
            (yield [$file, 2, new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\NullType()])]);
            (yield [$file, 3, new \PHPStan\Type\UnionType([new \PHPStan\Type\IntegerType(), new \PHPStan\Type\NullType()])]);
            (yield [$file, 4, new \PHPStan\Type\ObjectType(\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\Source\Abc::class)]);
            (yield [$file, 5, new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType(\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\Source\Abc::class), new \PHPStan\Type\NullType()])]);
            (yield [$file, 6, new \PHPStan\Type\ObjectType(\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\Source\Abc::class)]);
            (yield [$file, 7, new \PHPStan\Type\ObjectType(\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\Source\IDontExist::class)]);
            (yield [$file, 8, new \PHPStan\Type\ObjectType(\RectorPrefix20210127\A\B\C\IDontExist::class)]);
            (yield [$file, 9, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType())]);
            (yield [$file, 10, new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\ObjectType(\Rector\NodeTypeResolver\Tests\PerNodeTypeResolver\PropertyFetchTypeResolver\Source\Abc::class))]);
            (yield [$file, 11, new \PHPStan\Type\MixedType()]);
            (yield [$file, 12, new \PHPStan\Type\MixedType()]);
            (yield [$file, 13, new \PHPStan\Type\ErrorType()]);
        }
        (yield [__DIR__ . '/Source/propertyFetchOnMixedVar.php', 0, new \PHPStan\Type\MixedType()]);
        (yield [__DIR__ . '/Source/propertyFetchOnMixedVar.php', 1, new \PHPStan\Type\MixedType()]);
        (yield [__DIR__ . '/Source/propertyFetchOnMixedVar.php', 2, new \PHPStan\Type\MixedType()]);
    }
}
