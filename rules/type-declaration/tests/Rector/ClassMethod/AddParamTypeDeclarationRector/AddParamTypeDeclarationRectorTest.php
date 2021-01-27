<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector;

use Iterator;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Contract\ParentInterfaceWithChangeTypeInterface;
use Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ClassMetadataFactory;
use Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ParserInterface;
use Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo;
final class AddParamTypeDeclarationRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class => [\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => [new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Contract\ParentInterfaceWithChangeTypeInterface::class, 'process', 0, new \PHPStan\Type\StringType()), new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ParserInterface::class, 'parse', 0, new \PHPStan\Type\StringType()), new \Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ClassMetadataFactory::class, 'setEntityManager', 0, new \PHPStan\Type\ObjectType('Doctrine\\ORM\\EntityManagerInterface'))]]];
    }
}
