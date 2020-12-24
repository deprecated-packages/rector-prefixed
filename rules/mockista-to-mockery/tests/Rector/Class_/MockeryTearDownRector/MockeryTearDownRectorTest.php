<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\MockistaToMockery\Tests\Rector\Class_\MockeryTearDownRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\MockistaToMockery\Rector\Class_\MockeryTearDownRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class MockeryTearDownRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\MockistaToMockery\Rector\Class_\MockeryTearDownRector::class;
    }
}
