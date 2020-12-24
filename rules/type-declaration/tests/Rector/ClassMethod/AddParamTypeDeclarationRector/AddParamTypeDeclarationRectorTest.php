<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Contract\ParentInterfaceWithChangeTypeInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ClassMetadataFactory;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ParserInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class AddParamTypeDeclarationRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => [new \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Contract\ParentInterfaceWithChangeTypeInterface::class, 'process', 0, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType()), new \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ParserInterface::class, 'parse', 0, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType()), new \_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ClassMetadataFactory::class, 'setEntityManager', 0, new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType('_PhpScoper2a4e7ab1ecbc\\Doctrine\\ORM\\EntityManagerInterface'))]]];
    }
}
