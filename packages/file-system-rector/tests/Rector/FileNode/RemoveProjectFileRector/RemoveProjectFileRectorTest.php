<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\Tests\Rector\FileNode\RemoveProjectFileRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\Rector\FileNode\RemoveProjectFileRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveProjectFileRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fixtureFileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\Rector\FileNode\RemoveProjectFileRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\Rector\FileNode\RemoveProjectFileRector::FILE_PATHS_TO_REMOVE => ['file_to_be_removed.php']]];
    }
}
