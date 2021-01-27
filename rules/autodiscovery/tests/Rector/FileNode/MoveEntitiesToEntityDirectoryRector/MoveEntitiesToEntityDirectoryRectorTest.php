<?php

declare (strict_types=1);
namespace Rector\Autodiscovery\Tests\Rector\FileNode\MoveEntitiesToEntityDirectoryRector;

use Iterator;
use Rector\Autodiscovery\Rector\FileNode\MoveEntitiesToEntityDirectoryRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileSystem;
final class MoveEntitiesToEntityDirectoryRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo, \Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent) : void
    {
        $this->doTestFileInfo($originalFileInfo);
        $this->assertFileWithContentWasAdded($expectedAddedFileWithContent);
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileSystem();
        (yield [new \RectorPrefix20210127\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/Controller/RandomEntity.php'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/Entity/RandomEntity.php', $smartFileSystem->readFile(__DIR__ . '/Expected/ExpectedRandomEntity.php'))]);
    }
    protected function getRectorClass() : string
    {
        return \Rector\Autodiscovery\Rector\FileNode\MoveEntitiesToEntityDirectoryRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES - 1;
    }
}
