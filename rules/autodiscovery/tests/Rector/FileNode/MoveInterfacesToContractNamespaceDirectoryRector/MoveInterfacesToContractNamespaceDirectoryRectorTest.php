<?php

declare (strict_types=1);
namespace Rector\Autodiscovery\Tests\Rector\FileNode\MoveInterfacesToContractNamespaceDirectoryRector;

use Iterator;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileSystem;
final class MoveInterfacesToContractNamespaceDirectoryRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     * @param SmartFileInfo[] $extraFileInfos
     */
    public function test(\RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, ?\Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent, array $extraFileInfos = []) : void
    {
        $this->doTestFileInfo($originalFileInfo, $extraFileInfos);
        if ($expectedAddedFileWithContent !== null) {
            $this->assertFileWithContentWasAdded($expectedAddedFileWithContent);
        } else {
            $this->assertFileWasNotChanged($this->originalTempFileInfo);
        }
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileSystem();
        $extraFileInfos = [new \RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/RandomInterfaceUseCase.php'), new \RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/ValueObject/SameClassImplementEntity.php'), new \RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Entity/RandomInterfaceUseCaseInTheSameNamespace.php')];
        (yield [
            new \RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Entity/RandomInterface.php'),
            new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Contract/RandomInterface.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ExpectedRandomInterface.php')),
            // extra files
            $extraFileInfos,
        ]);
        // skip nette control factory
        (yield [new \RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Control/ControlFactory.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Control/ControlFactory.php', $smartFileSystem->readFile(__DIR__ . '/Source/Control/ControlFactory.php'))]);
        // skip form control factory, even in docblock
        (yield [new \RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Control/FormFactory.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Control/FormFactory.php', $smartFileSystem->readFile(__DIR__ . '/Source/Control/FormFactory.php'))]);
        // skip already in correct location
        (yield [new \RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Contract/KeepThisSomeInterface.php'), null]);
        // skip already in correct location
        (yield [new \RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Contract/Foo/KeepThisSomeInterface.php'), null]);
    }
    protected function provideConfigFilePath() : string
    {
        return __DIR__ . '/config/some_config.php';
    }
}
