<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests;

use Iterator;
use PHPStan\Type\ArrayType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use PHPStan\Type\UnionType;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\StaticTypeMapper\StaticTypeMapper;
use Rector\TypeDeclaration\TypeNormalizer;
use RectorPrefix20210107\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class TypeNormalizerTest extends \RectorPrefix20210107\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var TypeNormalizer
     */
    private $typeNormalizer;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->typeNormalizer = $this->getService(\Rector\TypeDeclaration\TypeNormalizer::class);
        $this->staticTypeMapper = $this->getService(\Rector\StaticTypeMapper\StaticTypeMapper::class);
    }
    /**
     * @dataProvider provideDataNormalizeArrayOfUnionToUnionArray()
     */
    public function testNormalizeArrayOfUnionToUnionArray(\PHPStan\Type\ArrayType $arrayType, string $expectedDocString) : void
    {
        $arrayDocString = $this->staticTypeMapper->mapPHPStanTypeToDocString($arrayType);
        $this->assertSame($expectedDocString, $arrayDocString);
        $unionType = $this->typeNormalizer->normalizeArrayOfUnionToUnionArray($arrayType);
        $this->assertInstanceOf(\PHPStan\Type\UnionType::class, $unionType);
        $unionDocString = $this->staticTypeMapper->mapPHPStanTypeToDocString($unionType);
        $this->assertSame($expectedDocString, $unionDocString);
    }
    public function provideDataNormalizeArrayOfUnionToUnionArray() : \Iterator
    {
        $unionType = new \PHPStan\Type\UnionType([new \PHPStan\Type\StringType(), new \PHPStan\Type\IntegerType()]);
        $arrayType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $unionType);
        (yield [$arrayType, 'int[]|string[]']);
        $arrayType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $unionType);
        $moreNestedArrayType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $arrayType);
        (yield [$moreNestedArrayType, 'int[][]|string[][]']);
        $evenMoreNestedArrayType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $moreNestedArrayType);
        (yield [$evenMoreNestedArrayType, 'int[][][]|string[][][]']);
    }
}
