<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\Tests\TypeMapper;

use Iterator;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\IntegerType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\PHPStan\Type\UnionType;
use _PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\TypeMapper\ArrayTypeMapper;
use _PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class ArrayTypeMapperTest extends \_PhpScoper0a6b37af0871\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var ArrayTypeMapper
     */
    private $arrayTypeMapper;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoper0a6b37af0871\Rector\Core\HttpKernel\RectorKernel::class);
        $this->arrayTypeMapper = $this->getService(\_PhpScoper0a6b37af0871\Rector\PHPStanStaticTypeMapper\TypeMapper\ArrayTypeMapper::class);
    }
    /**
     * @dataProvider provideDataWithoutKeys()
     * @dataProvider provideDataUnionedWithoutKeys()
     */
    public function testWithoutKeys(\_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType $arrayType, string $expectedResult) : void
    {
        $actualTypeNode = $this->arrayTypeMapper->mapToPHPStanPhpDocTypeNode($arrayType);
        $this->assertSame($expectedResult, (string) $actualTypeNode);
    }
    /**
     * @dataProvider provideDataWithKeys()
     */
    public function testWithKeys(\_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType $arrayType, string $expectedResult) : void
    {
        $actualTypeNode = $this->arrayTypeMapper->mapToPHPStanPhpDocTypeNode($arrayType);
        $this->assertSame($expectedResult, (string) $actualTypeNode);
    }
    public function provideDataWithoutKeys() : \Iterator
    {
        $arrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType());
        (yield [$arrayType, 'string[]']);
        $stringStringUnionType = new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType()]);
        $arrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $stringStringUnionType);
        (yield [$arrayType, 'string[]']);
    }
    public function provideDataUnionedWithoutKeys() : \Iterator
    {
        $stringAndIntegerUnionType = new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType()]);
        $unionArrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $stringAndIntegerUnionType);
        (yield [$unionArrayType, 'int[]|string[]']);
        $moreNestedUnionArrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $unionArrayType);
        (yield [$moreNestedUnionArrayType, 'int[][]|string[][]']);
        $evenMoreNestedUnionArrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $moreNestedUnionArrayType);
        (yield [$evenMoreNestedUnionArrayType, 'int[][][]|string[][][]']);
    }
    public function provideDataWithKeys() : \Iterator
    {
        $arrayMixedToStringType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType());
        $arrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType(), $arrayMixedToStringType);
        (yield [$arrayType, 'array<string, string[]>']);
        $stringAndIntegerUnionType = new \_PhpScoper0a6b37af0871\PHPStan\Type\UnionType([new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType()]);
        $stringAndIntegerUnionArrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $stringAndIntegerUnionType);
        $arrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType(), $stringAndIntegerUnionArrayType);
        (yield [$arrayType, 'array<string, array<int|string>>']);
        $arrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\IntegerType());
        (yield [$arrayType, 'array<string, int>']);
    }
}
