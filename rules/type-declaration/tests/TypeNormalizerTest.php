<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Tests;

use Iterator;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeNormalizer;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class TypeNormalizerTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel::class);
        $this->typeNormalizer = $this->getService(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeNormalizer::class);
        $this->staticTypeMapper = $this->getService(\_PhpScoper0a6b37af0871\Rector\StaticTypeMapper\StaticTypeMapper::class);
    }
    /**
     * @dataProvider provideDataNormalizeArrayOfUnionToUnionArray()
     */
    public function testNormalizeArrayOfUnionToUnionArray(\_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType $arrayType, string $expectedDocString) : void
    {
        $arrayDocString = $this->staticTypeMapper->mapPHPStanTypeToDocString($arrayType);
        $this->assertSame($expectedDocString, $arrayDocString);
        $unionType = $this->typeNormalizer->normalizeArrayOfUnionToUnionArray($arrayType);
        $this->assertInstanceOf(\_PhpScoper0a6b37af0871\PHPStan\Type\UnionType::class, $unionType);
        $unionDocString = $this->staticTypeMapper->mapPHPStanTypeToDocString($unionType);
        $this->assertSame($expectedDocString, $unionDocString);
    }
    public function provideDataNormalizeArrayOfUnionToUnionArray() : \Iterator
    {
        $unionType = new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType()]);
        $arrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $unionType);
        (yield [$arrayType, 'int[]|string[]']);
        $arrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $unionType);
        $moreNestedArrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $arrayType);
        (yield [$moreNestedArrayType, 'int[][]|string[][]']);
        $evenMoreNestedArrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $moreNestedArrayType);
        (yield [$evenMoreNestedArrayType, 'int[][][]|string[][][]']);
    }
}
