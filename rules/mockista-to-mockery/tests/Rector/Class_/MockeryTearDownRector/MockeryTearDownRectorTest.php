<?php

declare (strict_types=1);
namespace Rector\MockistaToMockery\Tests\Rector\Class_\MockeryTearDownRector;

use Iterator;
use Rector\MockistaToMockery\Rector\Class_\MockeryTearDownRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo;
final class MockeryTearDownRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210204\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\MockistaToMockery\Rector\Class_\MockeryTearDownRector::class;
    }
}
