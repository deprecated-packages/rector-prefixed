<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector;

use Iterator;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\NullType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\UnionType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\VoidType;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector\Source\PHPUnitTestCase;
use _PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class AddReturnTypeDeclarationRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        $arrayType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType(new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType(), new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType());
        $nullableObjectUnionType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\UnionType([new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType('SomeType'), new \_PhpScoper0a2ac50786fa\PHPStan\Type\NullType()]);
        return [\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class => [\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => [new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\Rector\\TypeDeclaration\\Tests\\Rector\\ClassMethod\\AddReturnTypeDeclarationRector\\Fixture\\Fixture', 'parse', $arrayType), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\Rector\\TypeDeclaration\\Tests\\Rector\\ClassMethod\\AddReturnTypeDeclarationRector\\Fixture\\Fixture', 'resolve', new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType('SomeType')), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\Rector\\TypeDeclaration\\Tests\\Rector\\ClassMethod\\AddReturnTypeDeclarationRector\\Fixture\\Fixture', 'nullable', $nullableObjectUnionType), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoper0a2ac50786fa\\Rector\\TypeDeclaration\\Tests\\Rector\\ClassMethod\\AddReturnTypeDeclarationRector\\Fixture\\RemoveReturnType', 'clear', new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType()), new \_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration(\_PhpScoper0a2ac50786fa\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector\Source\PHPUnitTestCase::class, 'tearDown', new \_PhpScoper0a2ac50786fa\PHPStan\Type\VoidType())]]];
    }
}
