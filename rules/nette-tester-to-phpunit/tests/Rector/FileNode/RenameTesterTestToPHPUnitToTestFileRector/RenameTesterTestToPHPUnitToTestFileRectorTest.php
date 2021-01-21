<?php

declare (strict_types=1);
namespace Rector\NetteTesterToPHPUnit\Tests\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector;

use Iterator;
use Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use Rector\NetteTesterToPHPUnit\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo;
use RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileSystem;
final class RenameTesterTestToPHPUnitToTestFileRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo, \Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent) : void
    {
        $this->doTestFileInfo($fixtureFileInfo);
        $this->assertFileWithContentWasAdded($expectedAddedFileWithContent);
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileSystem();
        (yield [new \RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/SomeCase.phpt'), new \Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/SomeCaseTest.php', $smartFileSystem->readFile(__DIR__ . '/Source/SomeCase.phpt'))]);
    }
    protected function getRectorClass() : string
    {
        return \Rector\NetteTesterToPHPUnit\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector::class;
    }
}
