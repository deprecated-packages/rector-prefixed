<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector;

use Iterator;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Contract\ParentInterfaceWithChangeTypeInterface;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ClassMetadataFactory;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ParserInterface;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class AddParamTypeDeclarationRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return [\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class => [\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => [new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Contract\ParentInterfaceWithChangeTypeInterface::class, 'process', 0, new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ParserInterface::class, 'parse', 0, new \_PhpScoperb75b35f52b74\PHPStan\Type\StringType()), new \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ClassMetadataFactory::class, 'setEntityManager', 0, new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType('_PhpScoperb75b35f52b74\\Doctrine\\ORM\\EntityManagerInterface'))]]];
    }
}
