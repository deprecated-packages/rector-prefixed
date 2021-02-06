<?php

declare (strict_types=1);
namespace Rector\DeadCode\Tests\Rector\For_\RemoveDeadIfForeachForRector;

use Iterator;
use Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use RectorPrefix20210206\Symplify\SmartFileSystem\SmartFileInfo;
final class RemoveDeadIfForeachForRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210206\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector::class;
    }
}
