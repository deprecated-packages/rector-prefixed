<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\TryCatch\RemoveDeadTryCatchRector;

use Iterator;
use Rector\DeadCode\Rector\TryCatch\RemoveDeadTryCatchRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210309\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveDeadTryCatchRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210309\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\TryCatch\RemoveDeadTryCatchRector::class;
    }
}
