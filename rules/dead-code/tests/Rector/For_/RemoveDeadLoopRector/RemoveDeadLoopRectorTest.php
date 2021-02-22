<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\For_\RemoveDeadLoopRector;

use Iterator;
use Rector\DeadCode\Rector\For_\RemoveDeadLoopRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210222\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveDeadLoopRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210222\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\For_\RemoveDeadLoopRector::class;
    }
}
