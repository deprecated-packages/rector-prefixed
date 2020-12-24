<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteTesterToPHPUnit\Tests\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScoperb75b35f52b74\Rector\NetteTesterToPHPUnit\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
final class RenameTesterTestToPHPUnitToTestFileRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo, \_PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent) : void
    {
        $this->doTestFileInfo($fixtureFileInfo);
        $this->assertFileWithContentWasAdded($expectedAddedFileWithContent);
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem();
        (yield [new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/SomeCase.phpt'), new \_PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/SomeCaseTest.php', $smartFileSystem->readFile(__DIR__ . '/Source/SomeCase.phpt'))]);
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\NetteTesterToPHPUnit\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector::class;
    }
}
