<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector;

use Iterator;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\UnionType;
use PHPStan\Type\VoidType;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector;
use Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector\Source\PHPUnitTestCase;
use Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo;
final class AddReturnTypeDeclarationRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20201230\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        $arrayType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), new \PHPStan\Type\MixedType());
        $nullableObjectUnionType = new \PHPStan\Type\UnionType([new \PHPStan\Type\ObjectType('SomeType'), new \PHPStan\Type\NullType()]);
        return [\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::class => [\Rector\TypeDeclaration\Rector\ClassMethod\AddReturnTypeDeclarationRector::METHOD_RETURN_TYPES => [new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('Rector\\TypeDeclaration\\Tests\\Rector\\ClassMethod\\AddReturnTypeDeclarationRector\\Fixture\\Fixture', 'parse', $arrayType), new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('Rector\\TypeDeclaration\\Tests\\Rector\\ClassMethod\\AddReturnTypeDeclarationRector\\Fixture\\Fixture', 'resolve', new \PHPStan\Type\ObjectType('SomeType')), new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('Rector\\TypeDeclaration\\Tests\\Rector\\ClassMethod\\AddReturnTypeDeclarationRector\\Fixture\\Fixture', 'nullable', $nullableObjectUnionType), new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('Rector\\TypeDeclaration\\Tests\\Rector\\ClassMethod\\AddReturnTypeDeclarationRector\\Fixture\\RemoveReturnType', 'clear', new \PHPStan\Type\MixedType()), new \Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration(\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector\Source\PHPUnitTestCase::class, 'tearDown', new \PHPStan\Type\VoidType())]]];
    }
}
