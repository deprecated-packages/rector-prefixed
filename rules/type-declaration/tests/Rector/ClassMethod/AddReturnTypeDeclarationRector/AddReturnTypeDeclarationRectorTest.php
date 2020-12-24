<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector;

use Iterator;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\NullType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\VoidType;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector\Source\PHPUnitTestCase;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class AddReturnTypeDeclarationRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        $arrayType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType(new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType(), new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType());
        $nullableObjectUnionType = new \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType([new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType('SomeType'), new \_PhpScoperb75b35f52b74\PHPStan\Type\NullType()]);
        return [\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class => [\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => [new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\Rector\\TypeDeclaration\\Tests\\Rector\\ClassMethod\\AddReturnTypeDeclarationRector\\Fixture\\Fixture', 'parse', $arrayType), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\Rector\\TypeDeclaration\\Tests\\Rector\\ClassMethod\\AddReturnTypeDeclarationRector\\Fixture\\Fixture', 'resolve', new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType('SomeType')), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\Rector\\TypeDeclaration\\Tests\\Rector\\ClassMethod\\AddReturnTypeDeclarationRector\\Fixture\\Fixture', 'nullable', $nullableObjectUnionType), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('_PhpScoperb75b35f52b74\\Rector\\TypeDeclaration\\Tests\\Rector\\ClassMethod\\AddReturnTypeDeclarationRector\\Fixture\\RemoveReturnType', 'clear', new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector\Source\PHPUnitTestCase::class, 'tearDown', new \_PhpScoperb75b35f52b74\PHPStan\Type\VoidType())]]];
    }
}
