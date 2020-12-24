<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector;

use Iterator;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Contract\ParentInterfaceWithChangeTypeInterface;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ClassMetadataFactory;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ParserInterface;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class AddParamTypeDeclarationRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::class => [\_PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod\AddParamTypeDeclarationRector::PARAMETER_TYPEHINTS => [new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Contract\ParentInterfaceWithChangeTypeInterface::class, 'process', 0, new \_PhpScopere8e811afab72\PHPStan\Type\StringType()), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ParserInterface::class, 'parse', 0, new \_PhpScopere8e811afab72\PHPStan\Type\StringType()), new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddParamTypeDeclaration(\_PhpScopere8e811afab72\Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddParamTypeDeclarationRector\Source\ClassMetadataFactory::class, 'setEntityManager', 0, new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType('_PhpScopere8e811afab72\\Doctrine\\ORM\\EntityManagerInterface'))]]];
    }
}
