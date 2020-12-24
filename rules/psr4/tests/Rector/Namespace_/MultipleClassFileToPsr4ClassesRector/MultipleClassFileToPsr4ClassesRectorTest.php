<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PSR4\Tests\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector;
use _PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScoper0a6b37af0871\Rector\PSR4\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
final class MultipleClassFileToPsr4ClassesRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @param AddedFileWithContent[] $expectedFilePathsWithContents
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, array $expectedFilePathsWithContents) : void
    {
        /** @var RemovedAndAddedFilesCollector $removedAndAddedFilesCollector */
        $removedAndAddedFilesCollector = $this->getService(\_PhpScoper0a6b37af0871\Rector\Core\Application\FileSystem\RemovedAndAddedFilesCollector::class);
        $removedAndAddedFilesCollector->reset();
        $this->doTestFileInfo($originalFileInfo);
        $this->assertFilesWereAdded($expectedFilePathsWithContents);
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem();
        // source: https://github.com/nette/utils/blob/798f8c1626a8e0e23116d90e588532725cce7d0e/src/Utils/exceptions.php
        $filePathsWithContents = [new \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/RegexpException.php', $smartFileSystem->readFile(__DIR__ . '/Expected/RegexpException.php')), new \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/UnknownImageFileException.php', $smartFileSystem->readFile(__DIR__ . '/Expected/UnknownImageFileException.php'))];
        (yield [new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/nette-exceptions.php'), $filePathsWithContents]);
        $filePathsWithContents = [new \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/JustOneExceptionWithoutNamespace.php', $smartFileSystem->readFile(__DIR__ . '/Expected/JustOneExceptionWithoutNamespace.php')), new \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/JustTwoExceptionWithoutNamespace.php', $smartFileSystem->readFile(__DIR__ . '/Expected/JustTwoExceptionWithoutNamespace.php'))];
        (yield [new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/without-namespace.php'), $filePathsWithContents]);
        $filePathsWithContents = [new \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/MyTrait.php', $smartFileSystem->readFile(__DIR__ . '/Expected/MyTrait.php')), new \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/MyClass.php', $smartFileSystem->readFile(__DIR__ . '/Expected/MyClass.php')), new \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/MyInterface.php', $smartFileSystem->readFile(__DIR__ . '/Expected/MyInterface.php'))];
        (yield [new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/ClassTraitAndInterface.php.inc'), $filePathsWithContents]);
        // keep original class
        (yield [
            new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/SomeClass.php'),
            // extra files
            [new \_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/SomeClass_Exception.php', $smartFileSystem->readFile(__DIR__ . '/Expected/SomeClass_Exception.php'))],
        ]);
        (yield [new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/ReadyException.php.inc'), []]);
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\PSR4\Rector\Namespace_\MultipleClassFileToPsr4ClassesRector::class;
    }
}
