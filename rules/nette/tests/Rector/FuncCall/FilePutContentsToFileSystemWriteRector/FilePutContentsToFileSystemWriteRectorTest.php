<?php

declare (strict_types=1);
namespace Rector\Nette\Tests\Rector\FuncCall\FilePutContentsToFileSystemWriteRector;

use Iterator;
use Rector\Nette\Rector\FuncCall\FilePutContentsToFileSystemWriteRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileInfo;
final class FilePutContentsToFileSystemWriteRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210208\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\Nette\Rector\FuncCall\FilePutContentsToFileSystemWriteRector::class;
    }
}
