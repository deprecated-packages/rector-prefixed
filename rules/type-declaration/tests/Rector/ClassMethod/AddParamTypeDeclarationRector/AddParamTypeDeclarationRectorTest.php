<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector;

use Iterator;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\PHPStan\Type\StringType;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Contract\ParentInterfaceWithChangeTypeInterface;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ClassMetadataFactory;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ParserInterface;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class AddParamTypeDeclarationRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class => [\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => [new \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Contract\ParentInterfaceWithChangeTypeInterface::class, 'process', 0, new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType()), new \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ParserInterface::class, 'parse', 0, new \_PhpScoper0a6b37af0871\PHPStan\Type\StringType()), new \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ClassMetadataFactory::class, 'setEntityManager', 0, new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType('_PhpScoper0a6b37af0871\\Doctrine\\ORM\\EntityManagerInterface'))]]];
    }
}
