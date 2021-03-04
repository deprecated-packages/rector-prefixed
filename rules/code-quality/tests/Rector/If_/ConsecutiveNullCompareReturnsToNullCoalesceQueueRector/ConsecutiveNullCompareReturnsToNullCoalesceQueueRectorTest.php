<?php

declare (strict_types=1);
namespace Rector\CodeQuality\Tests\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector;

use Iterator;
use Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo;
final class ConsecutiveNullCompareReturnsToNullCoalesceQueueRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector::class;
    }
}
