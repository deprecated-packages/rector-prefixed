<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\Tests\TypeMapper;

use Iterator;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeMapper\ArrayTypeMapper;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class ArrayTypeMapperTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var ArrayTypeMapper
     */
    private $arrayTypeMapper;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->arrayTypeMapper = $this->getService(\_PhpScopere8e811afab72\Rector\PHPStanStaticTypeMapper\TypeMapper\ArrayTypeMapper::class);
    }
    /**
     * @dataProvider provideDataWithoutKeys()
     * @dataProvider provideDataUnionedWithoutKeys()
     */
    public function testWithoutKeys(\_PhpScopere8e811afab72\PHPStan\Type\ArrayType $arrayType, string $expectedResult) : void
    {
        $actualTypeNode = $this->arrayTypeMapper->mapToPHPStanPhpDocTypeNode($arrayType);
        $this->assertSame($expectedResult, (string) $actualTypeNode);
    }
    /**
     * @dataProvider provideDataWithKeys()
     */
    public function testWithKeys(\_PhpScopere8e811afab72\PHPStan\Type\ArrayType $arrayType, string $expectedResult) : void
    {
        $actualTypeNode = $this->arrayTypeMapper->mapToPHPStanPhpDocTypeNode($arrayType);
        $this->assertSame($expectedResult, (string) $actualTypeNode);
    }
    public function provideDataWithoutKeys() : \Iterator
    {
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType());
        (yield [$arrayType, 'string[]']);
        $stringStringUnionType = new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType()]);
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $stringStringUnionType);
        (yield [$arrayType, 'string[]']);
    }
    public function provideDataUnionedWithoutKeys() : \Iterator
    {
        $stringAndIntegerUnionType = new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType()]);
        $unionArrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $stringAndIntegerUnionType);
        (yield [$unionArrayType, 'int[]|string[]']);
        $moreNestedUnionArrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $unionArrayType);
        (yield [$moreNestedUnionArrayType, 'int[][]|string[][]']);
        $evenMoreNestedUnionArrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $moreNestedUnionArrayType);
        (yield [$evenMoreNestedUnionArrayType, 'int[][][]|string[][][]']);
    }
    public function provideDataWithKeys() : \Iterator
    {
        $arrayMixedToStringType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\StringType());
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), $arrayMixedToStringType);
        (yield [$arrayType, 'array<string, string[]>']);
        $stringAndIntegerUnionType = new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType()]);
        $stringAndIntegerUnionArrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $stringAndIntegerUnionType);
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), $stringAndIntegerUnionArrayType);
        (yield [$arrayType, 'array<string, array<int|string>>']);
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType());
        (yield [$arrayType, 'array<string, int>']);
    }
}
