<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\FileSystemRector\Tests\Rector\FileNode\RemoveProjectFileRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\Rector\FileNode\RemoveProjectFileRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveProjectFileRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
    {
        $this->doTestFileInfo($fixtureFileInfo);
        $this->assertFileWasRemoved($this->originalTempFileInfo);
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
        return [\_PhpScoperb75b35f52b74\Rector\FileSystemRector\Rector\FileNode\RemoveProjectFileRector::class => [\_PhpScoperb75b35f52b74\Rector\FileSystemRector\Rector\FileNode\RemoveProjectFileRector::FILE_PATHS_TO_REMOVE => ['file_to_be_removed.php']]];
    }
}
