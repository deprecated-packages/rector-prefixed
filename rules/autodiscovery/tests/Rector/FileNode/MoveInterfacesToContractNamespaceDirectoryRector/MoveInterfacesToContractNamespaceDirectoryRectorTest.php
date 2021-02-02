<?php

declare (strict_types=1);
namespace Rector\Autodiscovery\Tests\Rector\FileNode\MoveInterfacesToContractNamespaceDirectoryRector;

use Iterator;
use Rector\Autodiscovery\Rector\FileNode\MoveInterfacesToContractNamespaceDirectoryRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Testing\ValueObject\InputFilePathWithExpectedFile;
use RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileSystem;
final class MoveInterfacesToContractNamespaceDirectoryRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     * @param InputFilePathWithExpectedFile[] $extraFiles
     */
    public function test(\RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, ?\Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent, array $extraFiles = []) : void
    {
        $this->doTestFileInfo($originalFileInfo, $extraFiles);
        if ($expectedAddedFileWithContent !== null) {
            $this->assertFileWithContentWasAdded($expectedAddedFileWithContent);
        } else {
            $this->assertFileWasNotChanged($this->originalTempFileInfo);
        }
        $expectedAddedFilesWithContent = [];
        foreach ($extraFiles as $extraFile) {
            $expectedAddedFilesWithContent[] = $extraFile->getAddedFileWithContent();
        }
        $this->assertFilesWereAdded($expectedAddedFilesWithContent);
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileSystem();
        $extraFiles = [new \Rector\Testing\ValueObject\InputFilePathWithExpectedFile(__DIR__ . '/Source/RandomInterfaceUseCase.php', new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/RandomInterfaceUseCase.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ExpectedRandomInterfaceUseCase.php'))), new \Rector\Testing\ValueObject\InputFilePathWithExpectedFile(__DIR__ . '/Source/ValueObject/SameClassImplementEntity.php', new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Entity/SameClassImplementEntity.php', $smartFileSystem->readFile(__DIR__ . '/Expected/Entity/ExpectedSameClassImplementEntity.php'))), new \Rector\Testing\ValueObject\InputFilePathWithExpectedFile(__DIR__ . '/Source/Entity/RandomInterfaceUseCaseInTheSameNamespace.php', new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Entity/RandomInterfaceUseCaseInTheSameNamespace.php', $smartFileSystem->readFile(__DIR__ . '/Expected/Entity/RandomInterfaceUseCaseInTheSameNamespace.php')))];
        (yield [
            new \RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Entity/RandomInterface.php'),
            new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Contract/RandomInterface.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ExpectedRandomInterface.php')),
            // extra files
            $extraFiles,
        ]);
        // skip nette control factory
        (yield [new \RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Control/ControlFactory.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Control/ControlFactory.php', $smartFileSystem->readFile(__DIR__ . '/Source/Control/ControlFactory.php'))]);
        // skip form control factory, even in docblock
        (yield [new \RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Control/FormFactory.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Control/FormFactory.php', $smartFileSystem->readFile(__DIR__ . '/Source/Control/FormFactory.php'))]);
        // skip already in correct location
        (yield [new \RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Contract/KeepThisSomeInterface.php'), null]);
        // skip already in correct location
        (yield [new \RectorPrefix20210202\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Contract/Foo/KeepThisSomeInterface.php'), null]);
    }
    protected function getRectorClass() : string
    {
        return \Rector\Autodiscovery\Rector\FileNode\MoveInterfacesToContractNamespaceDirectoryRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1;
    }
}
