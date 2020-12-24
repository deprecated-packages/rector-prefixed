<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Tests;

use Iterator;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeNormalizer;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class TypeNormalizerTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->typeNormalizer = $this->getService(\_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeNormalizer::class);
        $this->staticTypeMapper = $this->getService(\_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper::class);
    }
    /**
     * @dataProvider provideDataNormalizeArrayOfUnionToUnionArray()
     */
    public function testNormalizeArrayOfUnionToUnionArray(\_PhpScopere8e811afab72\PHPStan\Type\ArrayType $arrayType, string $expectedDocString) : void
    {
        $arrayDocString = $this->staticTypeMapper->mapPHPStanTypeToDocString($arrayType);
        $this->assertSame($expectedDocString, $arrayDocString);
        $unionType = $this->typeNormalizer->normalizeArrayOfUnionToUnionArray($arrayType);
        $this->assertInstanceOf(\_PhpScopere8e811afab72\PHPStan\Type\UnionType::class, $unionType);
        $unionDocString = $this->staticTypeMapper->mapPHPStanTypeToDocString($unionType);
        $this->assertSame($expectedDocString, $unionDocString);
    }
    public function provideDataNormalizeArrayOfUnionToUnionArray() : \Iterator
    {
        $unionType = new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\StringType(), new \_PhpScopere8e811afab72\PHPStan\Type\IntegerType()]);
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $unionType);
        (yield [$arrayType, 'int[]|string[]']);
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $unionType);
        $moreNestedArrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $arrayType);
        (yield [$moreNestedArrayType, 'int[][]|string[][]']);
        $evenMoreNestedArrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $moreNestedArrayType);
        (yield [$evenMoreNestedArrayType, 'int[][][]|string[][][]']);
    }
}
