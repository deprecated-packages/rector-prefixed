<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\Tests\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent;
use _PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
final class RenameTesterTestToPHPUnitToTestFileRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo, \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent $expectedAddedFileWithContent) : void
    {
        $this->doTestFileInfo($fixtureFileInfo);
        $this->assertFileWithContentWasAdded($expectedAddedFileWithContent);
    }
    public function provideData() : \Iterator
    {
        $smartFileSystem = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem();
        (yield [new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Source/SomeCase.phpt'), new \_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObject\AddedFileWithContent($this->getFixtureTempDirectory() . '/Source/SomeCaseTest.php', $smartFileSystem->readFile(__DIR__ . '/Source/SomeCase.phpt'))]);
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\NetteTesterToPHPUnit\Rector\FileNode\RenameTesterTestToPHPUnitToTestFileRector::class;
    }
}
