<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\FileSystemRector\Tests\Rector\FileNode\RemoveProjectFileRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Rector\FileSystemRector\Rector\FileNode\RemoveProjectFileRector;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveProjectFileRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\FileSystemRector\Rector\FileNode\RemoveProjectFileRector::class => [\_PhpScoper0a2ac50786fa\Rector\FileSystemRector\Rector\FileNode\RemoveProjectFileRector::FILE_PATHS_TO_REMOVE => ['file_to_be_removed.php']]];
    }
}
