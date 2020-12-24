<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Tests\Rector\FileNode\RenameSpecFileToTestFileRector;

use Iterator;
use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\Rector\FileSystemRector\Contract\MovedFileInterface;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\FileNode\RenameSpecFileToTestFileRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameSpecFileToTestFileRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
        // test file is moved
        $movedFile = $this->matchMovedFile($this->originalTempFileInfo);
        $this->assertInstanceOf(\_PhpScopere8e811afab72\Rector\FileSystemRector\Contract\MovedFileInterface::class, $movedFile);
        $this->assertTrue(\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($movedFile->getNewPathname(), 'Test.php'));
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture', '*.php');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\FileNode\RenameSpecFileToTestFileRector::class;
    }
}
