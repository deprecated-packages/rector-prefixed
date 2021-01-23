<?php

declare (strict_types=1);
namespace Rector\Autodiscovery\Tests\Rector\FileNode\MoveServicesBySuffixToDirectoryRector;

use Iterator;
use Rector\Autodiscovery\Rector\FileNode\MoveServicesBySuffixToDirectoryRector;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210123\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210123\Symplify\SmartFileSystem\SmartFileSystem;
final class MoveServicesBySuffixToDirectoryRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210123\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, ?\Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent) : void
    {
        $this->doTestFileInfo($originalFileInfo);
        if ($expectedAddedFileWithContent === null) {
            // no change - file should have the original location
            $this->assertFileWasNotChanged($this->originalTempFileInfo);
        } else {
            $this->assertFileWithContentWasAdded($expectedAddedFileWithContent);
        }
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \RectorPrefix20210123\Symplify\SmartFileSystem\SmartFileSystem();
        (yield [new \RectorPrefix20210123\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Entity/AppleRepository.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Repository/AppleRepository.php', $smartFileSystem->readFile(__DIR__ . '/Expected/Repository/ExpectedAppleRepository.php'))]);
        (yield [new \RectorPrefix20210123\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Controller/BananaCommand.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Command/BananaCommand.php', $smartFileSystem->readFile(__DIR__ . '/Expected/Command/ExpectedBananaCommand.php'))]);
        (yield [new \RectorPrefix20210123\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Command/MissPlacedController.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Controller/MissPlacedController.php', $smartFileSystem->readFile(__DIR__ . '/Expected/Controller/MissPlacedController.php'))]);
        // nothing changes
        (yield [new \RectorPrefix20210123\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Mapper/SkipCorrectMapper.php'), null]);
        (yield [new \RectorPrefix20210123\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Controller/Nested/AbstractBaseWithSpaceMapper.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Mapper/Nested/AbstractBaseWithSpaceMapper.php', $smartFileSystem->readFile(__DIR__ . '/Expected/Mapper/Nested/AbstractBaseWithSpaceMapper.php.inc'))]);
        // inversed order, but should have the same effect
        (yield [new \RectorPrefix20210123\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Entity/UserMapper.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Mapper/UserMapper.php', $smartFileSystem->readFile(__DIR__ . '/Expected/Mapper/UserMapper.php.inc'))]);
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Autodiscovery\Rector\FileNode\MoveServicesBySuffixToDirectoryRector::class => [\Rector\Autodiscovery\Rector\FileNode\MoveServicesBySuffixToDirectoryRector::GROUP_NAMES_BY_SUFFIX => ['Repository', 'Command', 'Mapper', 'Controller']]];
    }
}
